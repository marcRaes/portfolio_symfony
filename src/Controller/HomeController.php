<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Entity\User;
use App\Repository\DevToolsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\QuotesRepository;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use App\Security\DemoUserAuthenticatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AllowDynamicProperties]
class HomeController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly SkillsRepository $skillsRepository,
        private readonly DevToolsRepository $devToolsRepository,
        private readonly ProjectsRepository $projectsRepository,
        private readonly QuotesRepository $quotesRepository,
        private readonly DemoUserAuthenticatorService $demoUserAuthenticator,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly RequestStack $requestStack
    ) {}

    #[Route('/{isDemo}', name: 'app_home', requirements: ['isDemo' => '0|1'], defaults: ['isDemo' => 0])]
    public function index(bool $isDemo): Response
    {
        $currentUser = $this->getUser();
        $request = $this->requestStack->getCurrentRequest();
        $session = $request?->getSession();

        if (!$isDemo && $currentUser instanceof User && in_array('ROLE_DEMO', $currentUser->getRoles(), true)) {
            $this->tokenStorage->setToken(null);
            $session?->invalidate();
        }

        $user = $isDemo
            ? $this->demoUserAuthenticator->authenticateDemoUser()
            : $this->userRepository->findOneByRole('ROLE_OWNER');

        if(!$user) {
            return $this->redirectToRoute('app_register');
        }

        $allProjects = $this->projectsRepository->findDisplay($user);
        $persoProjects = $this->projectsRepository->findPerso($user);
        $formationProjects = $this->projectsRepository->findPro($user);

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'allProjects' => $allProjects,
            'persoProjects' => $persoProjects,
            'formationProjects' => $formationProjects,
        ]);
    }
}
