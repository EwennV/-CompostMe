<?php

namespace App\Form;

use App\Entity\FillRateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FillRateTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('pourcentage', IntegerType::class, [
                'label' => 'Pourcentage de remplissage',

            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur',
                'attr' => [
                    'style' => 'width: 100px;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FillRateType::class,
        ]);
    }
}
