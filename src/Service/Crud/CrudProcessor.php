<?php

namespace App\Service\Crud;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CrudProcessor
{
    private FormInterface $form;

    public function __construct(
        private EntityManagerInterface $em,
        private FormFactoryInterface $formFactory,
        private ValidatorInterface $validator,
    ) {}

    public function process(
        object $entity,
        Request $request,
        string $formType,
        ?CrudHookInterface $hook = null
    ): ?object {
        $this->form = $this->formFactory->create($formType, $entity);
        $this->form->handleRequest($request);

        if (!$this->form->isSubmitted() || !$this->form->isValid()) {
            return null;
        }

        $hook?->beforeSave($entity);

        $this->em->persist($entity);
        $this->em->flush();

        $hook?->afterSave($entity);

        return $entity;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function delete(object $entity, ?CrudHookInterface $hook = null): void
    {
        $hook?->beforeDelete($entity);

        $this->em->remove($entity);
        $this->em->flush();

        $hook?->afterDelete($entity);
    }

    public function validate(object $entity): ConstraintViolationListInterface
    {
        return $this->validator->validate($entity);
    }
}
