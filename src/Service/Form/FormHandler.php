<?php

namespace App\Service\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler
{
    public function handle(FormInterface $form, Request $request): bool
    {
        $form->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }
}
