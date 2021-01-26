<?php

namespace App\Form;

use App\Entity\Chomage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChomageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chodebut', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('chofin', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('chonbheure', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('chomaintien', ChoiceType::class,[
                'choices' => [
                    'Oui' => 0,
                    'Non' => 1
                ],
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('chocommentaire', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            /*->add('sproid')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chomage::class,
        ]);
    }
}
