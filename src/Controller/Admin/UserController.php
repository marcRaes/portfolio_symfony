<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/edit/{id}', name: 'app_edit_user')]
    public function edit(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succés.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/User/edit.html.twig', [
            'user' => $user,
            'profilForm' => $form,
        ]);
    }

    #[Route('/header/{id}', name: 'app_user_header')]
    public function header(User $user): Response
    {
        return $this->render('partials/header.html.twig', [
            'user' => $user,
        ]);
    }
}
