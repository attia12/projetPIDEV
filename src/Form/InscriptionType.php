<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',NULL,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('prenom',NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('email',NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('mdp',NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('adresse',NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('num',NULL, array('attr' => array('class' => 'form-control','style' => 'margin-right:5px')))
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Medecin' => "Medecin",
                    
                    'Patient' => "Patient",
                ],])
                ->add('Img', FileType::class, )
                ->add("Submit",SubmitType::class,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px;background:#6495ED;')))
        ;
                 ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
