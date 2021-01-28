<?php

namespace App\Form;

use App\Entity\Frais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FraisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fratype',ChoiceType::class,[
                'choices' => [
                    'kilomètres' => 'kilomètres',
                    'repas' => 'repas',
                    'transport collectif' => 'transport collectif',
                    'autre' => 'autre'],
                'required'=>true
            ])
            ->add('fraquantite',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
                ])
            ->add('frataux',NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
                ])
           // ->add('fratotal',NumberType::class,[
           //     'attr' => ['class' => 'form-control'],
           //     'required'=>true
            //    ])
            ->add('fracommentaire',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            //->add('sproid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Frais::class,
        ]);
    }
}
