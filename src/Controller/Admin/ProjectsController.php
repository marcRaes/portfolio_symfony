<?php

namespace App\Controller\Admin;

use App\Entity\Projects;
use App\Entity\User;
use App\Form\ProjectsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/projects')]
class ProjectsController extends AbstractController
{
    #[Route('/create', name: 'app_create_projects')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Projects();
        $user = $this->getUser();
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUser($user);
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'Projet ajouté avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Projects/create.html.twig', [
            'projectsForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_projects')]
    public function edit(Projects $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectsType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'Projet modifié avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Projects/edit.html.twig', [
            'projectsForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_projects')]
    public function delete(Projects $projects, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($projects);
        $entityManager->flush();

        $this->addFlash('success', 'Projet supprimé avec succès.');

        return $this->redirectToRoute('app_admin');
    }
}
