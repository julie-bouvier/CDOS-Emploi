<?php

namespace App\Form;

use App\Entity\Avenant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvenantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avdebut',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true

            ])
            ->add('avtypemodif',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])

            ->add('avcommentaire',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ]);
            //->add('sproid')


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avenant::class,
        ]);
    }
}
