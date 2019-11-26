<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prenom',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'choices' => [
                    'Homme' => 'M',
                    'Femme' => 'F'
                ]
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays de résidence',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone',
                'attr'  => ['class' =>  'form-control rounded-0']
            ])
            ->add('mail', EmailType::class, [
                'attr'  =>  ['class' => 'form-control rounded-0']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'invalid_message' => 'Les mots de passe sont differents.',
                'options' => ['attr' => ['class' => 'password-field form-control rounded-0']],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Repetez mot de passe'
                ],
            ])
            ->add('category', ChoiceType::class, [
                'mapped'   => false,
                'label' => 'Vous êtes ?',
                'attr'  => ['class' =>  'form-control rounded-0'],
                'choices' => [
                    'Joueur' => 'player',
                    'Recruteur' => 'recruteur',
                    'Fans' => 'fans',
                ]
            ])
            /*->add('reservation', EntityType::class, [
                'mapped'        =>  false,
                'label'         =>  'Le client ayant réservé',
                'attr'  => ['class' =>  'form-control'],
                'class'         =>  Reservation::class,
                'choice_label'  =>  'client.name'
            ])*/
            /* TODO: Add the captcha system
             * ->add('captcha', CaptchaType::class)
             */
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter le CGU.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
