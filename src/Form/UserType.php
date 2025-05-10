<?php

namespace App\Form;

use App\Entity\User;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var ?User $user */
        $user = $options['data'] ?? null;

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Votre prénom doit comporter au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ]
            ])
        ;

        if ($user && !in_array('ROLE_DEMO', $user->getRoles(), true)) {
            $builder->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new Assert\Email()
                ]
            ]);
        }

        $builder->add('phone', PhoneNumberType::class, [
                'label' => 'Téléphone',
                'default_region' => 'FR',
                'format' => PhoneNumberFormat::NATIONAL,
                'required' => false,
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'required' => false
            ])
            ->add('job', TextType::class, [
                'label' => 'Poste',
                'required' => false,
                'constraints' => [
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Votre poste doit comporter au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ]
            ])
            ->add('urlLinkedin', TextType::class, [
                'label' => 'Linkedin',
                'required' => false,
            ])
            ->add('careerObjective', TextareaType::class, [
                'label' => 'Plan de carrière',
                'required' => false
            ])
            ->add('aboutMe', TextareaType::class, [
                'label' => 'À propos de moi',
                'required' => false
            ])
            ->add('picture', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    ]),
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
