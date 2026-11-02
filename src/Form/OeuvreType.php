<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\Technique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('titre')
        ->add('dateCreation', null, ['widget' => 'single_text'])
        ->add('description')
        ->add('estDetruite', null, ['required' => false])
        ->add('lieu', EntityType::class, [
            'class' => Lieu::class,
            'choice_label' => 'nom',
        ])
        ->add('artistes', EntityType::class, [
            'class' => Artiste::class,
            'choice_label' => 'pseudonyme',
            'multiple' => true,
            'required' => false,
        ])
        ->add('techniques', EntityType::class, [
            'class' => Technique::class,
            'choice_label' => 'nom',
            'multiple' => true,
        ])
        ->add('oeuvreRecouverte', EntityType::class, [
            'class' => Oeuvre::class,
            'choice_label' => 'titre',
            'required' => false,
            'placeholder' => 'Aucune',
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}
