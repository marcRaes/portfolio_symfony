<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Cache\CacheInterface;

readonly class UserEnabledChecker implements UserCheckerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private CacheInterface $cache
    ) {}
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isVerified()) {
            $tokenItem = $this->cache->getItem('user_verification_token_' . $user->getId());

            $url = $this->urlGenerator->generate('app_send_verification', [
                'token' => $tokenItem->get(),
            ]);

            $message = sprintf('Vous devez confirmer votre adresse email avant de pouvoir vous connecter. <a href="%s">Renvoyer l\'email</a>', $url);

            throw new CustomUserMessageAccountStatusException($message);
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {}
}
