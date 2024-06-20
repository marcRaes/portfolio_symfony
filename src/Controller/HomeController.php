<?php

namespace App\Controller;

use AllowDynamicProperties;
use App\Repository\DevToolsRepository;
use App\Repository\ProjectsRepository;
use App\Repository\QuotesRepository;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[AllowDynamicProperties]
class HomeController extends AbstractController
{
    public function __construct(
        UserRepository $userRepository,
        SkillsRepository $skillsRepository,
        DevToolsRepository $devToolsRepository,
        ProjectsRepository $projectsRepository,
        QuotesRepository $quotesRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->skillsRepository = $skillsRepository;
        $this->devToolsRepository = $devToolsRepository;
        $this->projectsRepository = $projectsRepository;
        $this->quotesRepository = $quotesRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $user = $this->userRepository->findOne();
        $skills = $this->skillsRepository->findDisplay($user);
        $devTools = $this->devToolsRepository->findDisplay($user);
        $allProjects = $this->projectsRepository->findDisplay($user);
        $persoProjects = $this->projectsRepository->findPerso($user);
        $formationProjects = $this->projectsRepository->findPro($user);
        $quotes = $this->quotesRepository->findDisplay();

        dump($skills);

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'skills' => $skills,
            'devTools' => $devTools,
            'allProjects' => $allProjects,
            'persoProjects' => $persoProjects,
            'formationProjects' => $formationProjects,
            'quotes' => $quotes,
        ]);
    }
}
