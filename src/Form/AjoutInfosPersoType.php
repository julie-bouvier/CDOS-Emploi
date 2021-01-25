<?php

namespace App\Form;

use App\Entity\SalarieInfosPerso;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\IntegerType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutInfosPersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('snom', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('snomjeunefille', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sprenom', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('sadresse', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('sportable', TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('stel', TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sdatenaissance',DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('slieunaissance', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sdptnaissance', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('snationalite', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sautre', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('snumsecu', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('ssituationfam', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('snbenfant', IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalarieInfosPerso::class,
        ]);
    }
}
