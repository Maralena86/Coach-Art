<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('name', TextType::class, [
                'label'=> 'Prénom: '
            ])
            ->add('lastname', TextType::class, [
                'label'=> 'Nom: '
            ])
            ->add('phone')
            ->add('description')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
