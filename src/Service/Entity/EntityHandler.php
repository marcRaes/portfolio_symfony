<?php

namespace App\Service\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Autoconfigure]
readonly class EntityHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private RequestStack $requestStack,
        private ?CsrfTokenManagerInterface $csrfTokenManager = null,
    ) {}

    public function save(object $entity, string $message = 'Enregistré avec succès.'): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $this->addFlash('success', $message);
    }

    public function remove(object $entity, Request $request, string $message = 'Supprimé avec succès.'): void
    {
        if ($this->isValidCsrf($request, 'delete_' . $entity->getId(), '_token')) {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();

            $this->addFlash('success', $message);
        }
    }

    private function isValidCsrf(Request $request, string $csrfId, string $field): bool
    {
        if (!$this->csrfTokenManager || empty($csrfId)) {
            return true;
        }

        return $this->csrfTokenManager->isTokenValid(
            new CsrfToken($csrfId, $request->get($field))
        );
    }

    private function addFlash(string $type, string $message): void
    {
        $this->requestStack->getSession()?->getFlashBag()->add($type, $message);
    }
}
