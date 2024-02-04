<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Ecole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class, [
                'label' => 'Nom de la formation',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Duree', TextType::class, [
                'label' => 'Duree de la formation',
                'attr' => ['class' => 'form-control'],
            ])
            // Ajouter le champ de sélection pour l'école
            ->add('ecole', EntityType::class, [
                'class' => Ecole::class,
                'label' => 'École',
                'attr' => ['class' => 'form-control'],
                'choice_label' => 'Nom', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
