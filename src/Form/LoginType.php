<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Email', NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('Mdp',PasswordType::class, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add("Submit",SubmitType::class,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px;background:#6495ED;')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
