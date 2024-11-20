<?php

namespace App\Form;

use App\Entity\location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTime', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('celsius')
            ->add('cloudy',ChoiceType::class,[
                'choices'=>[
                    'Zachmurzenie'=>'Zachmurzenie',
                    'Pochmurnie'=>'Pochmurnie',
                    'Mgliste'=>'Mgliste',
                    'Deszczowo'=>'Deszczowo',
                    'Burza'=>'Burza',
                    'Brak'=>'Brak',
                ]
            ])
            ->add('location', EntityType::class, [
                'class' => location::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
