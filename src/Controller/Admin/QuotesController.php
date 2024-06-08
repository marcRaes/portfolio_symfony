<?php

namespace App\Controller\Admin;

use App\Entity\Quotes;
use App\Form\QuotesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/quotes')]
class QuotesController extends AbstractController
{
    #[Route('/create', name: 'app_create_quotes')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quote = new Quotes();
        $user = $this->getUser();
        $form = $this->createForm(QuotesType::class, $quote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quote->setUser($user);
            $entityManager->persist($quote);
            $entityManager->flush();

            $this->addFlash('success', 'Citation ajoutée avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Quotes/create.html.twig', [
            'quotesForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_quotes')]
    public function edit(Quotes $quotes, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuotesType::class, $quotes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quotes);
            $entityManager->flush();

            $this->addFlash('success', 'Citation modifiée avec succès.');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('Admin/Quotes/edit.html.twig', [
            'quotes' => $quotes,
            'quotesForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_quotes')]
    public function delete(Quotes $quotes, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($quotes);
        $entityManager->flush();

        $this->addFlash('success', 'Citation supprimée avec succès.');

        return $this->redirectToRoute('app_admin');
    }
}
