<?php

namespace App\Service\Image;

use App\Entity\Projects;
use App\Entity\User;
use App\Event\ImageDeletedEvent;
use App\Interface\ImageHolderInterface;
use App\Service\Entity\EntityHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class ImageDeletionService
{
    private array $entityClassMap = [
        'user' => User::class,
        'project' => Projects::class,
    ];

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ImageManager $photoManager,
        private readonly EntityHandler $entityHandler,
        private readonly CsrfTokenManagerInterface $csrfTokenManager,
        private readonly EventDispatcherInterface $dispatcher,
    ) {}

    public function delete(string $type, int $id, Request $request): void
    {
        $entityClass = $this->entityClassMap[$type] ?? throw new NotFoundHttpException('Type d\'entité invalide.');
        $entity = $this->em->getRepository($entityClass)->find($id);

        if (!$entity instanceof ImageHolderInterface) {
            throw new NotFoundHttpException('Entité non trouvée ou invalide.');
        }

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('delete_' . $entity->getId(), $request->get('_token')))) {
            throw new AccessDeniedHttpException('Jeton CSRF invalide.');
        }

        $this->photoManager->delete($entity);
        $this->entityHandler->save($entity);

        $this->dispatcher->dispatch(new ImageDeletedEvent($entity));
    }
}