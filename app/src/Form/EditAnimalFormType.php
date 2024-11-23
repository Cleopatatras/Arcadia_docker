<?php

namespace App\Form;

use App\Entity\Animaux;
use App\Entity\Habitats;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class EditAnimalFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('race')
            ->add('image', FileType::class, [
                'label' => 'Nouvelle image',
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/png, image/jpeg, image/webp'
                ],
                'constraints' => [
                    new Image(
                        minWidth: 200,
                        maxWidth: 4000,
                        minHeight: 200,
                        maxHeight: 4000,
                        allowPortrait: false,
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ]
                    )
                ]
            ])
            ->add('habitat', EntityType::class, [
                'class' => Habitats::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animaux::class,
        ]);
    }
}