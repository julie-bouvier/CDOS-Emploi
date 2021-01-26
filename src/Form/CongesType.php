<?php

namespace App\Form;

use App\Entity\Conges;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CongesType extends AbstractType
{

    const Lundi = 'Lundi';
    const Mardi = 'Mardi';
    const Mercredi = 'Mercredi';
    const Jeudi = 'Jeudi';
    const Vendredi = 'Vendredi';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contype', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('condernierjour', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('conjourreprise', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('conjournormaltrav', ChoiceType::class,[
                'choices' => [
                    'Lundi' => self::Lundi,
                    'Mardi' => self::Mardi,
                    'Mercredi' => self::Mercredi,
                    'Jeudi' => self::Jeudi,
                    'Vendredi' => self::Vendredi,
                    ],
                'expanded' => true,
                'multiple' => true,
                /*'attr' => ['class' => 'form-control'],
                'required'=>true*/


            ])
            ->add('connbjourouvrablepris', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('concommentaire', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            //->add('sproid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conges::class,
        ]);
    }
}
