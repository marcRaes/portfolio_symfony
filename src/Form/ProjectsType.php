<?php

namespace App\Form;

use App\Entity\DevTools;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Repository\SkillsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new Assert\Length([
                        'min' => 4,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                    new Assert\NotBlank([
                        'message' => 'Le nom est obligatoire',
                    ]),
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'La description est obligatoire',
                    ]),
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => 'Url',
                'default_protocol' => 'https',
                'invalid_message' => 'L\'url {{ value }} n\'est pas valide',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'L\'URL est obligatoire',
                    ]),
                ]
            ])
            ->add('urlGit', UrlType::class, [
                'label' => 'Url Git',
                'default_protocol' => 'https',
                'required' => false,
            ])
            ->add('pictureFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
                'imagine_pattern' => 'my_thumb_small',
                'download_uri' => false,
                'constraints' => [
                    new Assert\Image([
                        'maxSize' => '10485760',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    ]),
                ],
            ])
            ->add('skills', EntityType::class, [
                'label' => 'Compétences',
                'class' => Skills::class,
                'choice_label' => 'name',
                'required' => true,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Vous devez sélectionner au moins une compétence.',
                    ]),
                ],
            ])
            ->add('devTools', EntityType::class, [
                'label' => 'Outils de développement',
                'class' => DevTools::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ]
            ])
            ->add('training', CheckboxType::class, [
                'label' => 'Projet personnel',
                'required' => false,
                'label_attr' => [
                    'class' => 'checkbox-switch',
                ],
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
            'data_class' => Projects::class,
        ]);
    }
}
