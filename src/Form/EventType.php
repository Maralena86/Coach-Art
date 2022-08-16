<?php

namespace App\Form;

use DateTime;
use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventType extends AbstractType
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
            ->add('image', TextType::class, [
                'label' => "Image",
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
            'data_class' => Event::class,
        ]);
    }
}
