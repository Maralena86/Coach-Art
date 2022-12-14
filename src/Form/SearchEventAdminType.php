<?php

namespace App\Form;


use App\Entity\User;
use App\DoctrineType\OptionTypeEnum;
use Symfony\Component\Form\AbstractType;
use App\DTO\Admin\SearchEventAdminCriteria;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchEventAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('name', TextType::class, [
        'label' => 'Nom',
        'required' => false
        ])
        
        ->add('status', ChoiceType::class, [
            'choices' =>[
                'Non validés' => 'Not approved',
                'Validés' => 'Validated'
            ], 
            'required' => false,
            ])
        // ->add('therapist', EntityType::class, [
        //     'label'=>'Thérapeute',
        //     'class'=> User::class,
        //     'choice_label' => 'name',
        //     'multiple' => true,
        //     'required' => false,
        //     ])  
        ->add('options', ChoiceType::class, [
            'choices' => [
                'Présentiel'=>OptionTypeEnum::OPTIONS_PRESENTIAL,
                'À distance'=>OptionTypeEnum::OPTIONS_REMOTE,
                'Tous les évenements'=>'Tous'
            ]          
        ])  
        ->add('send', SubmitType::class, [
            'label' => 'Rechercher',
        ]);     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchEventAdminCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
