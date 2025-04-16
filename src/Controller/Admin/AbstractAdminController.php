<?php

namespace App\Controller\Admin;

use App\Repository\DevToolsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\QuotesRepository;
use App\Repository\SkillsRepository;
use App\Service\Entity\EntityHandler;
use App\Service\Form\FormHandler;
use App\Service\Image\ImageManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractAdminController extends AbstractController
{
    public function __construct(
        protected readonly SkillsRepository $skillsRepository,
        protected readonly DevToolsRepository $devToolsRepository,
        protected readonly ProjectsRepository $projectsRepository,
        protected readonly QuotesRepository $quotesRepository,
        protected readonly EntityManagerInterface $entityManager,
        protected readonly ImageManager $photoManager,
        protected readonly EntityHandler $entityHandler,
        protected readonly FormHandler $formHandler,
    ) {}
}
