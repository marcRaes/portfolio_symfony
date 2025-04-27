<?php

namespace App\Controller\Admin;

use App\Entity\DevTools;
use App\Form\DevToolsType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tools')]
class DevToolsController extends AbstractAdminController
{
    #[Route('/view', name: 'app_view_tools')]
    public function view(): Response
    {
        $user = $this->getUser();
        $devTools = $user->getDevTools();

        return $this->render('admin/devTools/view.html.twig', [
            'user' => $user,
            'devTools' => $devTools,
        ]);
    }

    #[Route('/create', name: 'app_create_tools')]
    public function create(Request $request): Response
    {
        $devTools = new DevTools();
        $user = $this->getUser();
        $form = $this->createForm(DevToolsType::class, $devTools);

        if ($this->formHandler->handle($form, $request)) {
            $devTools->setUser($user);

            $this->entityHandler->save($devTools, 'Outils de développement ajouté avec succès !');

            return $this->redirectToRoute('app_view_tools');
        }

        return $this->render('admin/devTools/create.html.twig', [
            'devToolsForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_tools')]
    public function edit(#[MapEntity] DevTools $devTools, Request $request): Response
    {
        $form = $this->createForm(DevToolsType::class, $devTools);

        if ($this->formHandler->handle($form, $request)) {
            $this->entityHandler->save($devTools, 'Outils de développement modifié avec succès !');

            return $this->redirectToRoute('app_view_tools');
        }

        return $this->render('admin/devTools/edit.html.twig', [
            'devTools' => $devTools,
            'devToolsForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_tools')]
    public function delete(#[MapEntity] DevTools $devTools, Request $request): Response
    {
        $this->entityHandler->remove($devTools, $request, 'Outils de développement supprimé avec succès !');

        return $this->redirectToRoute('app_view_tools');
    }
}
