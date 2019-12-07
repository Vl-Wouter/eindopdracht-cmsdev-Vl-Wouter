<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class)
            ->add('client', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("u.roles LIKE :roles")
                        ->setParameter('roles', '%ROLE_CUSTOMER%');
                },
                'choice_label' => function ($user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                }
            ])
            ->add('employee', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where("u.roles LIKE :roles")
                        ->setParameter('roles', '%ROLE_EMPLOYEE%');
                }
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
            'data_class' => Task::class,
        ]);
    }
}
