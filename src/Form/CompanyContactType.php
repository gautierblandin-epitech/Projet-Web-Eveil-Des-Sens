<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Form\CompanyType;

class CompanyContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Email Address',
                    'class' => 'register-input-field'
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false,
                    'attr' => [
                        'placeholder' => 'Password',
                        'class' => 'register-input-field'
                    ]],
                'second_options' => ['label' => false,
                    'attr' => [
                        'placeholder' => 'Confirm Password',
                        'class' => 'register-input-field'
                    ]],
            ])
            ->add('first_name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'First Name',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('last_name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Last Name',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('company', CompanyType::class)
            ->add('register', SubmitType::class, [
                'label' => 'Register Account',
                'attr'=> [
                    'class' => 'register-button-input'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
