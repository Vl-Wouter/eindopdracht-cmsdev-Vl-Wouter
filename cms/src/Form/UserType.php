<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'label' => 'Voornaam',
                'required' => true,
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Naam',
                'required' => true,
            ])
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Beide wachtwoorden moeten hetzelfde zijn',
                'required' => true,
                'first_options' => [
                    'label' => 'Wachtwoord',
                ],
                'second_options' => [
                    'label' => 'Herhaal wachtwoord',
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Klant' => 'ROLE_CUSTOMER',
                    'Werknemer' => 'ROLE_EMPLOYEE',
                    'Onderaannemer' => 'ROLE_SUBCONTRACTOR'
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form__group__roles'
                ]
            ])
            ->add('Cost', MoneyType::class, [
                'label' => 'Tarief',
                'required' => true,
                'empty_data' => 0,
                'currency' => false,
            ])
            ->add('transport', MoneyType::class, [
                'label' => 'Transportkost',
                'required' => true,
                'currency' => false,
                'empty_data' => 0,
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn -primary',
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
