<?php

namespace App\Form\Admin;

use App\Entity\Role;
use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration(
                'Prénom',
                'Modification du prénom'
            ))
            ->add('lastName', TextType::class, $this->getConfiguration(
                'Nom',
                'Modification du nom'
            ))
            ->add('email', TextType::class, $this->getConfiguration(
                'Email',
                'Modification de l\'adresse email'
            ))
            ->add('userRoles', EntityType::class, [
                'label'        => 'Roles',
                'class'        => Role::class,
                'choice_label' => 'title',
                'multiple'     => true,
                'required'     => false
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
