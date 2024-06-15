<?php

namespace App\Form;

use App\Entity\User;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new Assert\Email()
                ]
            ])
            ->add('phone', PhoneNumberType::class, [
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
            ->add('catchPhrase', TextareaType::class, [
                'label' => 'Phrase d\'accroche',
                'required' => false
            ])
            ->add('photoFile', VichImageType::class, [
                'label' => 'Photo',
                'required' => false,
                'imagine_pattern' => 'my_thumb_small',
                'download_uri' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '10485760',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
