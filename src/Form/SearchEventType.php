<?php

namespace App\Form;

use App\Entity\User;
use App\DTO\SearchEventCriteria;
use Doctrine\ORM\EntityRepository;
use App\DoctrineType\OptionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SearchEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class,[
                'label'=>false,
                'date_widget'=>'single_text',            
            ])
            
            
            ->add('options', ChoiceType::class, [
                'label'=>"Status ",
                'choices' =>[
                    'Approuved'=>'Approved',
                    'Not Approuved'=>'Not approved'
                ], 
                'required' => false,
                ])
              
                ->add('options', ChoiceType::class, [
                    'required' => true,
                    'choices' => ['Présentiel'=>OptionTypeEnum::OPTIONS_PRESENTIAL,'À distance'=>OptionTypeEnum::OPTIONS_REMOTE]          
                ])  
                ->add('send', SubmitType::class, [
                    'label' => 'Envoyer',
                ]);     
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchEventCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
    // public function getBlockPrefix()
    // {
    //     return '';
    // }
}
