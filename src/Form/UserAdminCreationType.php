<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAdminCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('admin')
            ->add('role')
            ->add('email')
            ->add('password')
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('phoneNumber')
            ->add('birthdate', DateType::class)
            ->add('studies')
            ->add('gender')
            ->add('experience')
            ->add('availabilities')
            ->add('biography')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
