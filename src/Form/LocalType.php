<?php

namespace App\Form;

use App\Entity\Local;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class LocalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomBlock',TextType::class)
            ->add('nomPatient',TextType::class,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px;background:#6495DD;')))
            ->add('nomMedecin',TextType::class,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px;background:#6495DD;')))
            ->add('localisation',TextType::class)
            //->add("Submit",SubmitType::class,array('attr' => array('class' => 'form-control','style' => 'margin-right:5px;background:#6495ED;')))

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Local::class,
        ]);
    }
}
