<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    /**
     * configuration de base d'un champ
     *
     * @param string   $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfig($label,$placeholder, $options = []) {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
            ], $options) ;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfig("Titre de l'annonce","Choisissez un titre pour votre annonce") )
            ->add('slug', TextType::class,  $this->getConfig("Chaine URL","Adresse web", [
                'required' => false
            ]))
            ->add('coverImage', UrlType::class, $this->getConfig("URL de l'image principale ","Donnez l'adresse d'une image qui vous voulez la mettre en face"))
            ->add('intro', TextType::class, $this->getConfig("Introduction","Description globale de l'annonce"))
            ->add('content', TextareaType::class, $this->getConfig("Description détaillée","Description détaillée de l'annonce "))
            ->add('rooms', IntegerType::class, $this->getConfig("Nombre de chambres","Indiquez le nombre de chambres disponibles"))
            ->add('price', MoneyType::class,  $this->getConfig("Prix par nuit","Indiquez le prix que vous voulez pour une nuit"))
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
