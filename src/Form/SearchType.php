<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Search ...',
                    'class' => 'form-control'
                ]
            ])
            ->add('min', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Min ...',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new GreaterThan(0)
                ]
            ])
            ->add('max', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Max ...',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new GreaterThan(0)
                ]
            ])
            ->add('isEnabled', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input'
                ]
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'csrf_protection' => false,
        ]);
    }
}
