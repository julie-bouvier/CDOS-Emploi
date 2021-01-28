<?php

namespace App\Form;

use App\Entity\SalarieInfosPro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutInfosProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('snomemployeur', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])

            ->add('sposteoccupe', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>true
            ])
            ->add('sccns', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('snaturecontrat', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('stypetempstravail', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sgestcp', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
            ]])
            ->add('sdatedebut', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sdatefin', DateType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('sfinmotif', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('scomfin', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('s10congemois', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]])
            ->add('sconge', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
            ]])
            ->add('stypecontrat', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('smultiemployeur', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
            ]])
            ->add('svolhorairemois', NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('stauxhorairebrut', NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('ssalmoisbrut', NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('scomplemsante', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
            ]])
            ->add('sautreelement', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalarieInfosPro::class,
        ]);
    }
}
