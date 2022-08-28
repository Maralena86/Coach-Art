<?php

namespace App\Form;

use App\Entity\ArtEvent;
use App\DoctrineType\OptionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label'=>"Nom de l'evenement",
            'required'=>true
        ])
        ->add('description', TextareaType::class, [
            'label'=>"Description ",
            'required'=>true
        ])
        ->add('status', ChoiceType::class, [
            'label'=>"Status ",
            'choices' =>[
                'Approuved'=>'Approved',
                'Not Approuved'=>'Not approved'
            ],
            'required'=>true
        ])
        ->add('price', NumberType::class, [
            'label'=>"Prix",
            'required'=>true
        ])
        ->add('date', DateType::class,[
            'label'=>'Date',
            'placeholder' => [
            'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
        ]])         
        ->add('options', ChoiceType::class, [
            
            'required' => true,
            'choices' => ['Présentiel'=>OptionTypeEnum::OPTIONS_PRESENTIAL,'À distance'=>OptionTypeEnum::OPTIONS_REMOTE]          
        ])       
        ->add('imageFile', VichImageType::class,  [
            'allow_delete' => true,
            'delete_label' => 'Delete?',
            'download_label' => "Télecharger l'image",
            'download_uri' => true,
            'image_uri' => true,
            'asset_helper' => true,
            'required'=>true
        ])
        ->add('submit', SubmitType::class, [
            'label'=>'Envoyer',
        ])
        ;     
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArtEvent::class,
        ]);
    }
}
