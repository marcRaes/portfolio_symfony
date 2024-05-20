<?php

namespace App\Form;

use App\Entity\Quotes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuotesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Citation',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('display', CheckboxType::class, [
                'label' => 'Afficher',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quotes::class,
        ]);
    }
}
