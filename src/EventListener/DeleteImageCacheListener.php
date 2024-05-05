<?php

namespace App\EventListener;

use App\Entity\User;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Storage\StorageInterface;

final class DeleteImageCacheListener
{
    private StorageInterface $storage;

    private CacheManager $cacheManager;

    public function __construct(StorageInterface $storage, CacheManager $cacheManager)
    {
        $this->storage = $storage;
        $this->cacheManager = $cacheManager;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'vich_uploader.pre_remove' => 'onPreRemove',
        ];
    }

    public function onPreRemove(Event $event): void
    {
        $object = $event->getObject();

        if (!$object instanceof User) {
            return;
        }

        $filename = $this->getFilename($object);

        if ($filename !== null) {
            $this->cacheManager->remove($this->storage->resolveUri($object));
        }
    }

    private function getFilename(User $user): ?string
    {
        return $user->getPhoto();
    }
}
