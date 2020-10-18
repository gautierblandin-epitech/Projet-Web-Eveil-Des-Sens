<?php


namespace App\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


use App\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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

            ->add('email', EmailType::class, [
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

            ->add('adress', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adress',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Phone Number',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('birthdate', BirthdayType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'DD/MM/YYYY',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('studies', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Humanities ' => [
                        'Arts' => 'Arts',
                        'History' => 'History',
                        'Languages and literature' => 'Languages and literature',
                        'Law' => 'Law',
                        'Philosophy' => 'Philosophy',
                        'Theology' => 'Theology',
                    ],
                    'Social Sciences' => [
                        'Anthropology' => 'Anthropology',
                        'Economics' => 'Economics',
                        'Geography ' => 'Geography',
                        'Political science ' => 'Political science',
                        'Psychology ' => 'Psychology',
                        'Sociology ' => 'Sociology',
                    ],
                    'Natural and Formal Sciences' => [
                        'Biology ' => 'Biology',
                        'Chemistry ' => 'Chemistry',
                        'Earth science ' => 'Earth science',
                        'Space sciences ' => 'Space sciences',
                        'Physics ' => 'Physics',
                        'Computer Science ' => 'Computer Science',
                        'Mathematics ' => 'Mathematics',
                    ],
                    'Applied Sciences' => [
                        'Business ' => 'Business',
                        'Engineering and technology ' => 'Engineering and technology',
                        'Medicine and health ' => 'Medicine and health',
                    ],
                ],
                'attr' => [
                    'class' => 'register-input-field'
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Male' => 'Male',
                    'Female' => 'Female',
                    'Other' => 'Other',
                ],
                'attr' => [
                    'placeholder' => 'Gender',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('experience', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Previous working experience',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('availabilities', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Availabilities (per day, week, month..)',
                    'class' => 'register-input-field'
                ]
            ])
            ->add('biography', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Describe yourself...',
                    'class' => 'register-input-field'
                ]
            ])
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