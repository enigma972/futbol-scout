<?php

namespace App\Form;

use App\Entity\PlayerClub;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'label' =>  'Nom du club',
                'attr'  =>  [
                    'class' =>  'form-control',
                    'placeholder'   =>  'ex: Association Sportive Vita Club'
                ]
            ])
            ->add('abbrLabel', TextType::class, [
                'label' =>  'Nom du club en abbregé',
                'attr'  =>  [
                    'class' =>  'form-control',
                    'placeholder'   =>  'ex: AS VITA CLUB'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerClub::class,
        ]);
    }
}
