<?php

namespace App\Service\Security;

use App\Entity\User;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SignedUrlGenerator
{
    private const int TOKEN_TTL = 3600; // 1H
    private const string TOKEN_PREFIX = 'user_verification_token_';

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly string $timezone,
    ) {}

    public function generate(User $user): ?string
    {
        $cacheKey = self::TOKEN_PREFIX . $user->getId();

        return $this->cache->get($cacheKey, function (ItemInterface $item) {
            $item->expiresAfter(self::TOKEN_TTL);

            return bin2hex(random_bytes(32));
        });
    }

    public function canResend(User $user): bool
    {
        return !$this->cache->hasItem(self::TOKEN_PREFIX . $user->getId());
    }

    public function getNextAvailableResendTime(User $user): ?\DateTimeInterface
    {
        $item = $this->cache->getItem(self::TOKEN_PREFIX . $user->getId());

        if (!$item->isHit()) {
            return null;
        }

        return (new \DateTimeImmutable('now', new \DateTimeZone($this->timezone)))
            ->setTimestamp($item->getMetadata()['expiry']);
    }

    public function validateToken(User $user, string $token): bool
    {
        $item = $this->cache->getItem(self::TOKEN_PREFIX . $user->getId());

        return $item->isHit() && $item->get() === $token;
    }

    public function clear(User $user): void
    {
        $this->cache->deleteItem(self::TOKEN_PREFIX . $user->getId());
    }
}
