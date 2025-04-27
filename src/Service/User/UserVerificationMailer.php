<?php

namespace App\Service\User;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Service\Security\SignedUrlGenerator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

readonly class UserVerificationMailer
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private SignedUrlGenerator $signedUrlGenerator,
    ) {}

    public function send(User $user): void
    {
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('contact@marcraes.fr', 'Portfolio'))
                ->to($user->getEmail())
                ->subject('Confirmez votre adresse email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );

        $this->signedUrlGenerator->generate($user);
    }
}
