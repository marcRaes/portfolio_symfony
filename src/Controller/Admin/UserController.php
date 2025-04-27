<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\ImageUploadType;
use App\Form\UserType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user')]
class UserController extends AbstractAdminController
{
    #[Route('/profile', name: 'app_view_user')]
    public function index(Request $request): Response
    {
        $request->getSession()->set('previous_url', $request->getRequestUri());

        return $this->render('admin/user/profile.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_user')]
    public function edit(#[MapEntity] User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $request->getSession()->set('previous_url', $request->getRequestUri());

        if ($this->formHandler->handle($form, $request)) {
            $photoFile = $form->get('picture')->getData();
            if ($photoFile) {
                $this->photoManager->uploadAndReplace($user, $photoFile, ImageUploadType::USER);
            }

            $this->entityHandler->save($user, 'Profil mis à jour avec succés !');

            return $this->redirectToRoute('app_view_user');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'profilForm' => $form,
        ]);
    }

    #[Route('/header/{id:user}', name: 'app_user_header')]
    public function header(#[MapEntity] User $user): Response
    {
        return $this->render('partials/_header.html.twig', [
            'user' => $user,
        ]);
    }
}
