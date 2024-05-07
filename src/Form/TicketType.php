<?php

namespace App\Form;

use App\Entity\Composter;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'help' => 'Titre synthétique du SOS'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'help' => 'Détaillez au maximum le problème afin de mieux le régler'
            ])
            ->add('composter', EntityType::class, [
                'class' => Composter::class,
                'choice_label' => 'contact',
                'label' => 'Composteur concerné',
                'help' => 'Selectionnez le composteur concerné sur la carte ci-dessous'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
