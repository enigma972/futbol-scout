<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Prenom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('lastname', TextType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Nom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('nickname', TextType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Postnom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('pseudo', TextType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Surnom',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'required'  =>  false
            ])
            ->add('gender', ChoiceType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Sexe',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'choices'   =>  [
                    'Homme' =>  'homme',
                    'Femme' =>  'femme'
                ]
            ])
            ->add('birthday', BirthdayType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Date de naissance',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('country', CountryType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Pays de naissance',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('length', IntegerType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Taille',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('weight', IntegerType::class, [
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label' => 'Poids',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('strongFeets', ChoiceType::class, [
                'multiple'  =>  true,
                'expanded'  =>  true,
                'attr'      => ['class' =>  'rounded-0'],
                'choices'   => [
                    'Gauche'     => 'gauche',
                    'Droite'     => 'droite'
                ],
                'label_attr' =>  ['class'    =>  'font-weight-bold'],
            ])
            ->add('postes', ChoiceType::class, [
                'multiple'      =>  true,
                'expanded'      =>  true,
                'attr'          => ['class' =>  'rounded-0'],
                'choices'       => [
                    'Gardien'                   => 'Gardien',
                    'Defenseur central'         => 'Defenseur central',
                    'Lateral gauche'            => 'Lateral gauche',
                    'Lateral droit'             => 'Lateral droit',
                    'Milieu defensif'           => 'Milieu defensif',
                    'Milieu offensif'           => 'Milieu offensif',
                    'Attaquant de pointe'       => 'Attaquant de pointe',
                    'Elié droit'                => 'Elié droit',
                    'Elié gauche'               => 'Elié gauche',
                    'Attaquant axial'           => 'Attaquant axial',
                ],
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
            ])
            ->add('currentClub', EntityType::class, [
                'class' =>  Club::class,
                'choice_label' =>  function($club) {
                    return $club->getLabel();
                },
                'attr'  =>  ['class' =>  'form-control rounded-0'],
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
            ])
            ->add('status', ChoiceType::class, [
                'attr'      => ['class' =>  'form-control rounded-0'],
                'choices'   => [
                    'Libre'         => 'libre',
                    'Prêté'         => 'lent',
                    'Permanent'     => 'permanent'
                ],
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
            ])
            ->add('ambition', TextareaType::class, [
                'required'  =>  false,
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label'     => 'Status',
                'attr'      => ['class' =>  'form-control rounded-0']
            ])
            ->add('biographie', TextareaType::class, [
                'required'  =>  false,
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
                'label'     => 'Status',
                'attr'      => ['class' =>  'form-control rounded-0']
            ])
            ->add('level', ChoiceType::class, [
                'attr'      => ['class' =>  'form-control rounded-0'],
                'choices'   => [
                    'Amateur'       => 'amateur',
                    'Professionel'  => 'pro',
                ],
                'label_attr'=>  ['class'    =>  'font-weight-bold'],
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
