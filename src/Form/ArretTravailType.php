<?php

namespace App\Form;

use App\Entity\ArretTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArretTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attype', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('atprolongation',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('atdebut',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('atfin',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('at3jours',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('at3jnbh',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('at4jours',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('at4jnbh',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('atcommentaire',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            //->add('sproid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArretTravail::class,
        ]);
    }
}
