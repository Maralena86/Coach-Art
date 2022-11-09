<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ArtEvent;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use App\DoctrineType\OptionTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArtEventType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        
        $builder
        ->add('name', TextType::class, [
            'label'=>"Nom de l'evenement:",
            'required'=>true
        ])
        ->add('description', TextareaType::class, [
            'label'=>"Description: ",
            'required'=>true
        ])
        ->add('status', ChoiceType::class, [
            'label'=>"Status:",
            'choices' =>[
                'Valider'=>'Validated',
                'Non valider'=>'Not approved'
            ],
            'required'=>true
        ])
        ->add('price', NumberType::class, [
            'label'=>"Prix:",
            'required'=>true
        ])
        ->add('date', DateTimeType::class,[
            'label'=>'Date:',
            'date_widget'=>'single_text',
            
        ]) 
        ->add('therapist', EntityType::class, [
            'label'=>'Thérapeute:',
            'class'=> User::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                ->where('u.roles LIKE :role')
                ->setParameter('role', '%"'.'ROLE_THERAPIST'.'"%')
                ->orderBy('u.name', 'ASC')
                ;               
            },
            'choice_label' => 'name',
            'required' => false,
        ])        
        ->add('options', ChoiceType::class, [
            'label' => 'Options:',
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
            'required'=>false
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
