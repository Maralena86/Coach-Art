<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' =>'Prénom',
                'attr'=>array(
                    'placeholder' => 'Prenom'
                ),               
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' =>'Nom',
                'attr'=>array(
                    'placeholder' => 'Nom'
                ),               
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' =>'Email',
                'attr' => array(
                    'placeholder' => 'Email'
                ),               
                'required' => true
            ])
            
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' =>'Votre mot de passe',
                    'attr' => array(
                        'placeholder' => 'Votre mot de passe'
                    ),
                ],
                'second_options' => [
                    'label' =>'Repetez votre mot de passe',
                    'attr' => array(
                        'placeholder' => 'Repetez votre mot de passe'
                    )
                ]
            ])
            ->add('send', SubmitType::class, [
                'label' => "S'inscrire",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
