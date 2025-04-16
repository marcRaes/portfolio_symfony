<?php

namespace App\EventListener;

use App\Event\ImageUpdatedEvent;
use Psr\Log\LoggerInterface;

class ImageLoggerListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onImageUpdated(ImageUpdatedEvent $event): void
    {
        $entity = $event->getEntity();
        $action = $event->isDeleted() ? 'supprimée' : 'mise à jour';
        $type = (new \ReflectionClass($entity))->getShortName();
        $logId = method_exists($entity, 'getId') ? $entity->getId() : 'unknown';

        $this->logger->info("Image {$action} pour l'entité {$type} (id: {$logId}).");
    }
}
