<?php

// src/Form/Type/TaskType.php
namespace App\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use App\Entity\Task;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder
->add('task', TextType::class)
->add('dueDate', DateType::class)
->add('save', SubmitType::class)
;
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults([
        'data_class' => Task::class,
    ]);
}

}