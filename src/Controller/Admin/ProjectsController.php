<?php

namespace App\Controller\Admin;

use App\Entity\Projects;
use App\Enum\ImageUploadType;
use App\Form\ProjectsType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/projects')]
class ProjectsController extends AbstractAdminController
{
    #[Route('/view', name: 'app_view_projects')]
    public function view(Request $request): Response
    {
        $user = $this->getUser();
        $projects = $user->getProjects();

        $request->getSession()->set('previous_url', $request->getRequestUri());

        return $this->render('admin/projects/view.html.twig', [
            'user' => $user,
            'projects' => $projects,
        ]);
    }

    #[Route('/create', name: 'app_create_projects')]
    public function create(Request $request): Response
    {
        $project = new Projects();
        $user = $this->getUser();
        $form = $this->createForm(ProjectsType::class, $project);

        $request->getSession()->set('previous_url', $request->getRequestUri());

        if ($this->formHandler->handle($form, $request)) {
            $photoFile = $form->get('picture')->getData();
            if ($photoFile) {
                $this->photoManager->uploadAndReplace($project, $photoFile, ImageUploadType::PROJECT);
            }
            $project->setUser($user);

            $this->entityHandler->save($project, 'Projet ajouté avec succès !');

            return $this->redirectToRoute('app_view_projects');
        }

        return $this->render('admin/projects/create.html.twig', [
            'user' => $user,
            'projectsForm' => $form,
            'project' => $project,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_projects')]
    public function edit(#[MapEntity] Projects $project, Request $request): Response
    {
        $form = $this->createForm(ProjectsType::class, $project);

        $request->getSession()->set('previous_url', $request->getRequestUri());

        if ($this->formHandler->handle($form, $request)) {
            $photoFile = $form->get('picture')->getData();

            if ($photoFile) {
                $this->photoManager->uploadAndReplace($project, $photoFile, ImageUploadType::PROJECT);
            }

            $this->entityHandler->save($project, 'Projet modifié avec succès !');

            return $this->redirectToRoute('app_view_projects');
        }

        return $this->render('admin/projects/edit.html.twig', [
            'user' => $this->getUser(),
            'projectsForm' => $form,
            'project' => $project,
        ]);
    }

    #[Route('/delete-project/{id}', name: 'app_delete_projects', methods: ['DELETE'])]
    public function deleteProject(#[MapEntity] Projects $project, Request $request): Response
    {
        $this->entityHandler->remove($project, $request, 'Projet supprimé avec succès !');

        return $this->redirectToRoute('app_view_projects');
    }
}
