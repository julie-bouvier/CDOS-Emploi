<?php

namespace App\Form;

use App\Entity\SalarieInfosPerso;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('sdatenaissance',BirthdayType::class,[
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
            ->add('snationalite', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ],
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
