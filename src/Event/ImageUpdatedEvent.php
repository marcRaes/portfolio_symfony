<?php

namespace App\Event;

use App\Interface\ImageHolderInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ImageUpdatedEvent extends Event
{
    public const NAME = 'app.image_updated';

    public function __construct(
        private readonly ImageHolderInterface $entity,
        private readonly bool $isDeleted = false
    )
    {}

    public function getEntity(): ImageHolderInterface
    {
        return $this->entity;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }
}
