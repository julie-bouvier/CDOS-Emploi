<?php

namespace App\Form;

use App\Entity\Heures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeuresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heurtype', ChoiceType::class,[
                'choices' => [
                    'Heures supplémentaires' => 'Supplémentaires',
                    'Heures complémentaires' => 'Complémentaires',
                    'Heures de dépassement' => 'Dépassement'
                ],
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('heursem', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('heurnb', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('heurcommentaire', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            /* ->add('sproid')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Heures::class,
        ]);
    }
}
