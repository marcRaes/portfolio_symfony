<?php

namespace App\Controller\Admin;

use App\Service\Image\ImageDeletionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractAdminController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        $skillsCount = $this->skillsRepository->count(['user' => $this->getUser(), 'display' => true]);
        $devToolsCount = $this->devToolsRepository->count(['user' => $this->getUser(), 'display' => true]);
        $projectsCount = $this->projectsRepository->count(['user' => $this->getUser(), 'display' => true]);
        $quotesCount = $this->quotesRepository->count(['user' => $this->getUser(), 'display' => true]);

        return $this->render('admin/index.html.twig', [
            'user' => $this->getUser(),
            'skillsCount' => $skillsCount,
            'devToolsCount' => $devToolsCount,
            'projectsCount' => $projectsCount,
            'quotesCount' => $quotesCount,
        ]);
    }

    #[Route('/delete-picture/{type}/{id}', name: 'app_delete_picture')]
    public function deletePicture(string $type, int $id, Request $request, ImageDeletionService $deletionService): Response
    {
        $previousUrl = $request->getSession()->get('previous_url');
        $request->getSession()->remove('previous_url');

        $deletionService->delete($type, $id, $request);

        return $this->redirect($previousUrl);
    }
}
