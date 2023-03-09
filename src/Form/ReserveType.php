<?php

namespace App\Form;
use App\Entity\Local;
use App\Entity\Consultation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class ReserveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
     
        ->add('duree', TextType::class, [
            'attr' => ['class' => 'form-control'],
        ])
        ->add('date', DateType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('locaux', EntityType::class, [
            'class' => Local::class,
            'attr' => ['class' => 'form-control'],
        ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
