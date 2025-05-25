<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaintenanceController extends AbstractController
{
    #[Route('/maintenance', name: 'app_maintenance')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('maintenance/index.html.twig', [
            'user' => $userRepository->findOneByRole('ROLE_OWNER'),
        ]);
    }
}