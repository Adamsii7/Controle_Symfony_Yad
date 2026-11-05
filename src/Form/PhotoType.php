<?php

namespace App\Form;

use App\Entity\Benevole;
use App\Entity\Oeuvre;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $estNouvelle = $options['data']->getId() === null;

        $contraintes = [
            new File(
                maxSize: '5M',
                mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
                mimeTypesMessage: 'Merci d\'envoyer une image JPG, PNG ou WebP.',
            ),
        ];
        if ($estNouvelle) {
            $contraintes[] = new NotNull(message: 'Choisis une photo à importer.');
        }

        $builder
            ->add('datePriseVue', null, ['widget' => 'single_text'])
            ->add('fichier', FileType::class, [
                'label' => 'Photo (JPG, PNG ou WebP)',
                'mapped' => false,
                'required' => false,
                'constraints' => $contraintes,
            ])
            ->add('etatOeuvre')
            ->add('oeuvre', EntityType::class, [
                'class' => Oeuvre::class,
                'choice_label' => 'titre',
            ])
            ->add('benevole', EntityType::class, [
                'class' => Benevole::class,
                'choice_label' => fn (Benevole $b) => $b->getPrenom() . ' ' . $b->getNom(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
