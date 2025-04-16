<?php

namespace App\Controller\Admin;

use App\Entity\Quotes;
use App\Form\QuotesType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/quotes')]
class QuotesController extends AbstractAdminController
{
    #[Route('/view', name: 'app_view_quotes')]
    public function view(): Response
    {
        $user = $this->getUser();
        $quotes = $user->getQuotes();

        return $this->render('admin/quotes/view.html.twig', [
            'user' => $user,
            'quotes' => $quotes,
        ]);
    }

    #[Route('/create', name: 'app_create_quotes')]
    public function create(Request $request): Response
    {
        $quote = new Quotes();
        $user = $this->getUser();
        $form = $this->createForm(QuotesType::class, $quote);

        if ($this->formHandler->handle($form, $request)) {
            $quote->setUser($user);

            $this->entityHandler->save($quote, 'Citation ajoutée avec succès !');

            return $this->redirectToRoute('app_view_quotes');
        }

        return $this->render('admin/quotes/create.html.twig', [
            'quotesForm' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit_quotes')]
    public function edit(#[MapEntity] Quotes $quotes, Request $request): Response
    {
        $form = $this->createForm(QuotesType::class, $quotes);

        if ($this->formHandler->handle($form, $request)) {
            $this->entityHandler->save($quotes, 'Citation modifiée avec succès !');

            return $this->redirectToRoute('app_view_quotes');
        }

        return $this->render('admin/quotes/edit.html.twig', [
            'quotes' => $quotes,
            'quotesForm' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete_quotes')]
    public function delete(#[MapEntity] Quotes $quotes, Request $request): Response
    {
        $this->entityHandler->remove($quotes, $request, 'Citation supprimé avec succès !');

        return $this->redirectToRoute('app_view_quotes');
    }
}
