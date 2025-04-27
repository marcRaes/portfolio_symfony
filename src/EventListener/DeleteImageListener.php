<?php

namespace App\EventListener;

use App\Interface\ImageHolderInterface;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;

class DeleteImageListener
{
    private string $uploadDir;
    private Filesystem $fs;

    public function __construct(
        #[Autowire('%kernel.project_dir%/public/uploads/user')] string $uploadDir
    ) {
        $this->uploadDir = $uploadDir;
        $this->fs = new Filesystem();
    }

    public function preUpdate(ImageHolderInterface $entity, PreUpdateEventArgs $event): void
    {
        if (!$event->hasChangedField('picture')) {
            return;
        }

        $oldPicture = $event->getOldValue('picture');
        if ($oldPicture) {
            $this->deleteImagesByName($oldPicture);
        }
    }

    public function preRemove(ImageHolderInterface $entity, LifecycleEventArgs $event): void
    {
        if ($entity->getPicture()) {
            $this->deleteImagesByName($entity->getPicture());
        }
    }

    public function deleteImages(ImageHolderInterface $entity): void
    {
        if ($entity->getPicture()) {
            $this->deleteImagesByName($entity->getPicture());
        }
    }

    private function deleteImagesByName(string $filename): void
    {
        $paths = [
            $this->uploadDir . '/' . $filename,
            $this->uploadDir . '/64x64_' . $filename,
            $this->uploadDir . '/175x200_' . $filename,
        ];

        foreach ($paths as $path) {
            if ($this->fs->exists($path)) {
                $this->fs->remove($path);
            }
        }
    }
}