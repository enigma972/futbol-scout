<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PlayerDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('length', IntegerType::class, [
                'label' => 'Taille',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Poids',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('strongFeets', ChoiceType::class, [
                'multiple'  =>  true,
                'expanded'  =>  true,
                'attr'      => ['class' =>  'rounded-0'],
                'choices'   => [
                    'Gauche'     => 'left',
                    'Droite'     => 'right'
                ],
            ])
            ->add('postes', ChoiceType::class, [
                'multiple'      =>  true,
                'expanded'      =>  true,
                'attr'          => ['class' =>  'rounded-0'],
                'choices'       => [
                    'Lorem'         => 'Lorem',
                    'Ipsum'         => 'Ipsum',
                    'Sit'           => 'Sit',
                    'Amet'          => 'Amet',
                    'Dolor'         => 'Dolor',
                    'consectetur'   => 'consectetur',
                    'elit'          => 'elit',
                    'tempor'        => 'tempor',
                    'incididunt'    => 'incididunt',
                    'labore'        => 'labore',
                    'magna'         => 'magna',
                    'aliqua'        => 'aliqua',
                ],
            ])
            ->add('currentClub', TextType::class, [
                'label' => 'Club actuel',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('status', ChoiceType::class, [
                'attr'      => ['class' =>  'form-control rounded-0'],
                'choices'   => [
                    'Libre'     => 'libre',
                    'Prêté'     => 'lent',
                    'Licence'   =>  'licence'
                ]
            ])
            ->add('ambition', TextareaType::class, [
                'label' => 'Status',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('level', ChoiceType::class, [
                'attr'      => ['class' =>  'form-control rounded-0'],
                'choices'   => [
                    'Amateur'     => 'amateur',
                    'Professionel'     => 'pro',
                ]
            ])
            ->add('file', FileType::class, [
                'mapped'    =>  false,
                'attr'      =>  [
                    'class' =>  'custom-file-input',
                    'id'    =>  'customFile'
                ],
                'label_attr'=>  [
                    'class' =>  'custom-file-label',
                    'for'   =>  'customFile'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
