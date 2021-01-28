<?php

namespace App\Form;

use App\Entity\AutreAbsence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutreAbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('absdebut',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])

            ->add('absfin',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('absnbheure',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('abscommentaire',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
           // ->add('sproid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AutreAbsence::class,
        ]);
    }
}
