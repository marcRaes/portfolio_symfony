<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use App\Service\Crud\CrudProcessor;
use App\Service\Crud\UserRegistrationHook;
use App\Service\Security\SignedUrlGenerator;
use App\Service\User\UserVerificationMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected readonly UserRepository $userRepository,
        private readonly SignedUrlGenerator $signedUrlGenerator,
    ) {}

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, CrudProcessor $crud, UserRegistrationHook $hook): Response
    {
        if(count($this->userRepository->findAll()) > 0) {
            $this->addFlash('info', 'Impossible, un administrateur existe déja !');

            return $this->redirectToRoute('app_login');
        }

        $user = new User();
        $result = $crud->process($user, $request, RegistrationType::class, $hook);

        if ($result) {
            $this->addFlash('success', 'Votre compte a été créé. Veuillez confirmer votre email avant de vous connecter !');

            return $this->redirectToRoute('app_send_verification');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $this->createForm(RegistrationType::class, $user),
        ]);
    }

    #[Route('/verify/send/{token}', name: 'app_send_verification', defaults: ['token' => null])]
    public function sendVerification(?string $token, UserVerificationMailer $mailer, Request $request): Response
    {
        /** @var ?User $user */
        $user = $this->userRepository->findOneBy([]);

        if ($user->isVerified()) {
            $this->addFlash('info', 'Votre email est déjà confirmé !');

            return $this->redirectToRoute('app_admin');
        }

        if ($token !== null) {
            if (!$this->signedUrlGenerator->validateToken($user, $token)) {
                $this->addFlash('danger', 'Lien invalide ou expiré !');

                return $this->redirectToRoute('app_login');
            }

            if (!$this->signedUrlGenerator->canResend($user)) {
                $nextAttempt = $this->signedUrlGenerator->getNextAvailableResendTime($user);

                $this->addFlash('danger', sprintf(
                    'Impossible d\'envoyer un email maintenant. Vous pourrez réessayer à %s !',
                    $nextAttempt->format('H\hi')
                ));

                return $this->redirectToRoute('app_login');
            }
        }

        try {
            $mailer->send($user);
            if (!$request->getSession()->has('success')) {
                $this->addFlash('success', 'Un email de confirmation vous a été envoyé !');
            }
        } catch (\RuntimeException) {
            $this->addFlash('danger', 'Une erreur est survenue lors de l’envoi de l’email !');
        }

        return $this->redirectToRoute('app_login');
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, EmailVerifier $emailVerifier, TranslatorInterface $translator, Security $security): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        try {
            $emailVerifier->handleEmailConfirmation($request, $user);

            $security->login($user, UserAuthenticator::class, 'main');
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('danger', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse e-mail a été vérifiée, vous avez été connecté automatiquement !');

        return $this->redirectToRoute('app_admin');
    }
}
