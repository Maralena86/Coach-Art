<?php

namespace App\Form;


use App\DTO\SearchEventCriteria;

use App\DoctrineType\OptionTypeEnum;
use DateTimeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;

class SearchEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('date', DateType::class,[
            //     'label'=>false,
            //     'empty_data' => null,
            //     'widget'=>'single_text', 
            //     'required' => false, 
            //     'attr' => array(
            //         'placeholder' => 'mm/dd/yyyy'
            //     )     
            //     ])
            
                ->add('options', ChoiceType::class, [
                    'required' => true,
                    'label'=>false,
                    'choices' => ['En présentiel'=>OptionTypeEnum::OPTIONS_PRESENTIAL,'À distance'=>OptionTypeEnum::OPTIONS_REMOTE, 'Tous les évenements'=>'Tous', ]          
                ])  
                ->add('send', SubmitType::class, [
                    'label' => 'Rechercher',
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
