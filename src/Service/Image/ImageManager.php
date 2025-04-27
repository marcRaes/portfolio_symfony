<?php

namespace App\Service\Image;

use App\Enum\ImageUploadType;
use App\Event\ImageUpdatedEvent;
use App\EventListener\DeleteImageListener;
use App\Interface\ImageHolderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[Autoconfigure]
readonly class ImageManager
{
    public function __construct(
        private DeleteImageListener $deleteImageListener,
        private ImageUploader $imageUploader,
        private EventDispatcherInterface $eventDispatcher,
    ) {}

    public function uploadAndReplace(ImageHolderInterface $entity, UploadedFile $photo, ImageUploadType $type): void
    {
        $this->delete($entity);

        $filename = strtolower((new \ReflectionClass($entity))->getShortName() . '_' . $entity->getId());
        $stored = $this->imageUploader->uploadAndResize($photo, $filename, $type);
        $entity->setPicture($stored);

        $this->eventDispatcher->dispatch(new ImageUpdatedEvent($entity, false), ImageUpdatedEvent::NAME);
    }

    public function delete(ImageHolderInterface $entity): void
    {
        if (!$entity->getPicture()) {
            return;
        }

        $this->deleteImageListener->deleteImages($entity);
        $entity->setPicture(null);

        $this->eventDispatcher->dispatch(new ImageUpdatedEvent($entity, true), ImageUpdatedEvent::NAME);
    }
}