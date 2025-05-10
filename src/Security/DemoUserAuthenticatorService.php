<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

readonly class DemoUserAuthenticatorService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserAuthenticatorInterface $userAuthenticator,
        private UserAuthenticator $authenticator,
        private RequestStack $requestStack,
    ) {}

    public function authenticateDemoUser(): ?object
    {
        $user = $this->userRepository->findOneBy(['email' => $_ENV['APP_DEMO_EMAIL']]);

        if ($user) {
            $request = $this->requestStack->getCurrentRequest();
            $this->userAuthenticator->authenticateUser($user, $this->authenticator, $request);
        }

        return $user;
    }
}
