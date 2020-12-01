<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',TextType::class, [
                'attr' => [
                'placeholder' => 'La date à laquelle vous comptez arriver',
                ],
                'label' => " Date d'arrivée",
            
                
            ])
            ->add('endDate',TextType::class, [
                'attr' => [
                'placeholder' => 'La date à laquelle vous quittez',
               
                ],
                'label' => " Date de départ",
                
            ])

            ->add('commentaire', TextareaType::class, [
                'attr' => [
                'placeholder' => 'Saisissez votre commentaire si vous en avez un '
                
                ],
                'label' => " Commentaire",
                
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
