<?php

namespace App\Controller\Admin;

use App\Entity\Skills;
use App\Form\SkillsType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/skills')]
class SkillsController extends AbstractAdminController
{
    #[Route('/view', name: 'app_view_skills')]
    public function view(): Response
    {
        $user = $this->getUser();
        $skills = $user->getSkills();

        return $this->render('admin/skills/view.html.twig', [
            'user' => $user,
            'skills' => $skills,
        ]);
    }

    #[Route('/create', name: 'app_create_skills')]
    public function create(Request $request): Response
    {
        $skill = new Skills();
        $user = $this->getUser();
        $form = $this->createForm(SkillsType::class, $skill);

        if ($this->formHandler->handle($form, $request)) {
            $skill->setUser($user);

            $this->entityHandler->save($skill, 'Compétence ajoutée avec succès !');

            return $this->redirectToRoute('app_view_skills');
        }

        return $this->render('admin/skills/create.html.twig', [
            'skillsForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_skills')]
    public function edit(#[MapEntity] Skills $skill, Request $request): Response
    {
        $form = $this->createForm(SkillsType::class, $skill);

        if ($this->formHandler->handle($form, $request)) {
            $this->entityHandler->save($skill, 'Compétence modifiée avec succès !');

            return $this->redirectToRoute('app_view_skills');
        }

        return $this->render('admin/skills/edit.html.twig', [
            'skill' => $skill,
            'skillsForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_skill')]
    public function delete(#[MapEntity] Skills $skill, Request $request): Response
    {
        $this->entityHandler->remove($skill, $request, 'Compétence supprimée avec succès !');

        return $this->redirectToRoute('app_view_skills');
    }
}
