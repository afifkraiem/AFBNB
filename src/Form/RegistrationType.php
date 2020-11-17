<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class, [
                'attr' => [
                'placeholder' => 'Votre prénom ...'
                ],
                'label' => 'Prénom'
            ])
            ->add('lastName',TextType::class, [
                'attr' => [
                'placeholder' => 'Votre nom de famille ...'
                ],
                'label' => 'Nom'
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                'placeholder' => 'Votre adresse email'
                ],
                'label' => 'Email'
            ])
            ->add('picture',UrlType::class, [
                'attr' => [
                'placeholder' => 'URL de votre avatar ...'
                ],
                'label' => 'Photo de profil'
            ])
            ->add('password',PasswordType::class, [
                'attr' => [
                'placeholder' => 'Utilisez un mot de passe solide'
                ],
                'label' => 'Mot de passe'
            ])
            ->add('passwordConfirm',PasswordType::class, [
                'attr' => [
                'placeholder' => 'Veuillez confirmer votre mot de passe'
                ],
                'label' => 'Confirmation du mot de passe',
                
            ])
            ->add('introduction',TextType::class, [
                'attr' => [
                'placeholder' => 'Présentez vous en quelques mots'
                ],
                'label' => 'Présentation'
            ])
            ->add('description',TextareaType::class, [
                'attr' => [
                'placeholder' => 'Présentez vous en détails'
                ],
                'label' => 'Description détaillée'
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
