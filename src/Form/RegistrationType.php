<?php

namespace App\Form;

use App\Form\Model\UserRegistrationFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('plainPassword', RepeatedType ::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique !',
                'options'         => [
                    'attr' => [
                        'class' => 'password-field'
                    ]
                ],
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répéter votre mot de passe']
            ])
            ->add('agreedTerms', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}
