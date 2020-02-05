<?php

namespace App\Form;

use App\Entity\PlayerSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required'  =>  false,
                'label'     =>  false,
                'attr'      =>  [
                    'placeHolder'   =>  'Nom du joueur',
                    'class'         =>  'form-control rounded-0 form-control-lg-'
                    ]
            ])
            ->add('minAge', IntegerType::class, [
                'required'  =>  false,
                'label'     =>  false,
                'attr'      =>  [
                    'placeHolder'   =>  'Age minimum',
                    'class'         =>  'form-control rounded-0 form-control-lg-'
                ]
            ])
            ->add('maxAge', IntegerType::class, [
                'required'  =>  false,
                'label'     =>  false,
                'attr'      =>  [
                    'placeHolder'   =>  'Age maximum',
                    'class'         =>  'form-control rounded-0 form-control-lg-'
                ]
            ])
            ->add('license', ChoiceType::class, [
                'required'  =>  false,
                'label'     =>  false,
                'placeholder'   =>  'Type de license',
                'attr'      =>  [
                    'class'         =>  'form-control rounded-0 form-control-lg-'
                ],
                'choices'   =>  [
                    'permanent'     =>  'permanent',
                    'preté'         =>  'prete',
                    'libre'         =>  'libre',
                    'tout'        =>  'all',
                    
                ],

            ])
            ->add('level', ChoiceType::class, [
                'required'  =>  false,
                'label'     =>  false,
                'placeholder'   =>  'Niveau',
                'attr'      =>  [
                    'class'         =>  'form-control rounded-0 form-control-lg-'
                ],
                'choices'   =>  [
                    'professionel'    =>  'professionel',
                    'amateur'         =>  'amateur',
                    'tout'            =>  'all',
                    
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerSearch::class,
            'csrf_protection'   =>  false,
        ]);
    }
}
