<?php

namespace App\Service\Crud;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationHook extends AbstractCrudHook
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    ) {}

    public function beforeSave(object $entity): void
    {
        if (!$entity instanceof User) return;

        $hashedPassword = $this->hasher->hashPassword($entity, $entity->getPlainPassword());
        $entity->setPassword($hashedPassword);
        $entity->setRoles(['ROLE_ADMIN', 'ROLE_OWNER']);
    }
}
