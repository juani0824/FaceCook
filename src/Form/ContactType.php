<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
              'attr' => [
                    'readonly' => 'readonly',
                ]
            ])
            ->add('nom', TextType::class, [
               'attr' => [
                    'readonly' => 'readonly',
                ]
            ])

            ->add('portable', TelType::class, [
                'attr' => [
                    'readonly' => 'readonly',
                ]
            ])
            ->add('email', EmailType::class, [
              'required' => false,
                'attr' => [
                    'readonly' => 'readonly',
                ]
            ])
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
