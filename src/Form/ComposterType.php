<?php

namespace App\Form;

use App\Entity\AccessType;
use App\Entity\Composter;
use App\Entity\FillRateType;
use App\Entity\OwnerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longitude', NumberType::class)
            ->add('latitude', NumberType::class)
            ->add('contact', TextType::class)
            ->add('ownerType', EntityType::class, [
                'class' => OwnerType::class,
                'choice_label' => 'name',
                'label' => "Type de propriétaire"
            ])
            ->add('accessType', EntityType::class, [
                'class' => AccessType::class,
                'choice_label' => 'name',
                'label' => "Type d'accès"
            ])
            ->add('fillRate', EntityType::class, [
                'class' => FillRateType::class,
                'choice_label' => 'name',
                'label' => 'Taux de remplissage'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Composter::class,
        ]);
    }
}
