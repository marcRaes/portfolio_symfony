<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class MaintenanceListener
{
    public function __construct(
        private readonly RouterInterface $router,
        private readonly bool $maintenanceEnabled
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->maintenanceEnabled) {
            return;
        }

        $request = $event->getRequest();

        // Ne pas bloquer la page de maintenance elle-même
        if ($request->getPathInfo() === '/maintenance') {
            return;
        }

        $event->setResponse(new RedirectResponse($this->router->generate('app_maintenance')));
    }
}