<?php

namespace App\Form;

use App\Entity\Apply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('firstName',  TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'First Name'
                ]
            ])

            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Last Name'
                ]
            ])

            ->add('message',  TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Describe why you would be a good candidate for this position...'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email Adress',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter valid email adress'
                ]
            ])

            ->add('phone',  TelType::class, [
                'label' => 'Phone Number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Phone number'
                ]
            ])
            /*->add('resume', FileType::class, [
                'label' => 'Resume',
                'attr' => [
                    'class' => 'form-control',
                'placeholder' => 'Upload your resume',
                'data_class' => null,
                'required' => false,
                'mapped' => false,
                ]
            ])*/
            ->add('save', SubmitType::class, [
                'label' => 'Send Application',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apply::class,
        ]);
    }
}