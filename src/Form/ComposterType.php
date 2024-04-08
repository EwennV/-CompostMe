<?php

namespace App\Form;

use App\Entity\AccessType;
use App\Entity\Composter;
use App\Entity\FillRateType;
use App\Entity\OwnerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longitude')
            ->add('latitude')
            ->add('contact')
            ->add('OwnerType', EntityType::class, [
                'class' => OwnerType::class,
                'choice_label' => 'id',
            ])
            ->add('AccessType', EntityType::class, [
                'class' => AccessType::class,
                'choice_label' => 'id',
            ])
            ->add('FillRate', EntityType::class, [
                'class' => FillRateType::class,
                'choice_label' => 'id',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Composter::class,
        ]);
    }
}
