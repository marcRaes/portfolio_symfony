<?php

namespace App\Event;

use App\Interface\ImageHolderInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ImageDeletedEvent extends Event
{
    public function __construct(
        public readonly ImageHolderInterface $entity
    ) {}
}
