<?php

namespace App\Twig;

use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private readonly Security $security) {}

    public function getGlobals(): array
    {
        return [
            'isDemo' => $this->security->isGranted('ROLE_DEMO'),
        ];
    }
}
