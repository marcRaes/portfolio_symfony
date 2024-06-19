<?php

namespace App\Controller\Admin;

use App\Entity\DevTools;
use App\Form\DevToolsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tools')]
class DevToolsController extends AbstractController
{
    #[Route('/create', name: 'app_create_tools')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $devTools = new DevTools();
        $user = $this->getUser();
        $form = $this->createForm(DevToolsType::class, $devTools);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devTools->setUser($user);
            $entityManager->persist($devTools);
            $entityManager->flush();

            $this->addFlash('success', 'Outils de développement ajouté avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/DevTools/create.html.twig', [
            'devToolsForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_tools')]
    public function edit(DevTools $devTools, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevToolsType::class, $devTools);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($devTools);
            $entityManager->flush();

            $this->addFlash('success', 'Outils de développement modifié avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/DevTools/edit.html.twig', [
            'devTools' => $devTools,
            'devToolsForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_tools')]
    public function delete(DevTools $devTools, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($devTools);
        $entityManager->flush();

        $this->addFlash('success', 'Outils de développement supprimé avec succès.');

        return $this->redirectToRoute('app_admin');
    }
}
