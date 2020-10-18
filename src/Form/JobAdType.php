<?php

namespace App\Form;

use App\Entity\Ads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JobAdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Title'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description'
                ]
            ])
            ->add('wage', TextType::class, [
                'label' => 'Wage',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Wage'
                ]
            ])
            ->add('place', TextType::class, [
                'label' => 'Location',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Location'
                ]
            ])
//            ->add('creationDate')
            ->add('endDate', DateType::class, [
                'label' => 'End date',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
//            ->add('company')
            ->add('submit', SubmitType::class, [
                'label' => 'Make Ad',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ads::class,
        ]);
    }
}
