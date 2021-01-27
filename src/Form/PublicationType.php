<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PublicationType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
            'recette' => null,
            'publication' => null,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['recette'] === Publication::TYPE_FORM_CREATE_PUBLICATION) {
            $builder
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    
                ])
                ->add('contenu', TextareaType::class, [
                    'required' => false,
                ]);
        }

        if ($options['recette'] === Publication::TYPE_FORM_CREATED_RECETTE) {
            $builder
                ->add('titre', TextType::class, [
                    //'required' => false,
                ])
                ->add('description', TextType::class, [
                    //'required' => false,
                ])
                ->add('imageFile', VichImageType::class, [
                    //'required' => false,
                ])
                ->add('contenu', TextareaType::class, [
                    //'required' => false,
                ]);
        }

        if ($options['recette'] === Publication::TYPE_FORM_EDIT_PUBLICATION) {

            if ($options['publication']->getType() === true) {
                $builder
                    ->add('titre', TextType::class, [
                        'required' => false,
                    ])
                    ->add('description', TextType::class, [
                        'required' => false,
                    ])
                    ->add('imageFile', VichImageType::class, [
                        'required' => false,
                        'label' => 'Photo',
                    ])
                    ->add('contenu', TextareaType::class, [
                        'required' => false,
                    ]);
            } else {
                $builder
                    ->add('imageFile', VichImageType::class, [
                        'required' => false,
                        'label' => 'Photo',
                    ])
                    ->add('contenu', TextareaType::class, [
                        'required' => false,
                    ]);
            }
        }
    }
}
