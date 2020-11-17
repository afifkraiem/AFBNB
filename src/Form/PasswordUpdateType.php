<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'attr'=>[
                    'placeholder'=> 'Tapez votre  mot de passe actuel'
                ],
                'label'=> ' Mot de passe actuel '
            ])
            ->add('newPassword', PasswordType::class, [
                'attr'=>[
                    'placeholder'=> 'Tapez un nouveau mot de passe '
                ],
                'label'=> ' Nouveau mot de passe '
            ])
            ->add('confirmPassword', PasswordType::class, [
                'attr'=>[
                    'placeholder'=> 'Confirmez votre nouveau mot de passe '
                ],
                'label'=> ' Confirmation du nouveau mot de passe '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
