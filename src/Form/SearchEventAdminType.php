<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use App\DoctrineType\OptionTypeEnum;
use Symfony\Component\Form\AbstractType;
use App\DTO\Admin\SearchEventAdminCriteria;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
            'label'=>"Status ",
            'choices' =>[
                'Approuved'=>'Approved',
                'Not Approuved'=>'Not approved'
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
                'required' => true,
                'choices' => ['Présentiel'=>OptionTypeEnum::OPTIONS_PRESENTIAL,'À distance'=>OptionTypeEnum::OPTIONS_REMOTE]          
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
