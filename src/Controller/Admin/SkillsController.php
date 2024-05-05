<?php

namespace App\Controller\Admin;

use App\Entity\Skills;
use App\Form\SkillsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/skills')]
class SkillsController extends AbstractController
{
    #[Route('/create', name: 'app_create_skills')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $skill->setUser($this->getUser());
            $entityManager->persist($skill);
            $entityManager->flush();

            $this->addFlash('success', 'Compétence ajoutée avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Skills/create.html.twig', [
            'skillsForm' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_skills')]
    public function edit(Skills $skill, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skill);
            $entityManager->flush();

            $this->addFlash('success', 'Compétence modifiée avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Skills/edit.html.twig', [
            'skill' => $skill,
            'skillsForm' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_skills')]
    public function delete(Skills $skill, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($skill);
        $entityManager->flush();

        $this->addFlash('success', 'Compétence supprimée avec succès.');

        return $this->redirectToRoute('app_admin');
    }
}
