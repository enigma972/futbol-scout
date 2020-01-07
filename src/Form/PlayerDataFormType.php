<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\PlayerClub as Club;


class PlayerDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prenom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Postnom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'required'  =>  false
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sexe',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'choices'   =>  [
                    'Homme' =>  'homme',
                    'Femme' =>  'femme'
                ]
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays de naissance',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
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
            ->add('currentClub', EntityType::class, [
                'class' =>  Club::class,
                'choice_label' =>  function($club) {
                    return $club->getLabel();
                },
                'attr'  =>  ['class' =>  'form-control rounded-0']
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
            ->add('biographie', TextareaType::class, [
                'label' => 'Status',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('level', ChoiceType::class, [
                'attr'      => ['class' =>  'form-control rounded-0'],
                'choices'   => [
                    'Amateur'       => 'amateur',
                    'Professionel'  => 'pro',
                ]
            ])
            /*->add('file', FileType::class, [
                'mapped'    =>  false,
                'attr'      =>  [
                    'class' =>  'custom-file-input',
                    'id'    =>  'customFile'
                ],
                'label_attr'=>  [
                    'class' =>  'custom-file-label',
                    'for'   =>  'customFile',
                    'style' =>  'overflow: hidden',
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
