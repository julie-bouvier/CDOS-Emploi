<?php

namespace App\Form;

use App\Entity\Prime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('primtype', TextType::class,[
            'attr' => ['class' => 'form-control'],
            'required'=>true
             ])
            ->add('primmontant', NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('primnetbrut', ChoiceType::class,[
                'choices' => [
                    'Net' => 'Net',
                    'Brut' => 'Brut'
                ],
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('primcommentaire', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            /*->add('sproid')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prime::class,
        ]);
    }
}
