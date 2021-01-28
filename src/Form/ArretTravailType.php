<?php

namespace App\Form;

use App\Entity\ArretTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('attype', ChoiceType::class,[
                'choices' => [
                    'Maladie' => 'Maladie',
                    'Accident de travail/trajet' => 'Accident de travail/trajet',
                    'Maternité' => 'Maternité',
                    'Paternité' => 'Paternité'],
                'required'=>true

                ])
            ->add('atprolongation',ChoiceType::class,[
                'choices' => [
                    'Initial' => 'Initial',
                    'Prolongation' => 'Prolongation'],
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
            ->add('at3jours',ChoiceType::class,[
                'choices' => [
                    'Oui' => 'oui',
                    'Non' => 'non'],
                'required'=>true
            ])
            ->add('at3jnbh',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('at4jours',ChoiceType::class,[
                'choices' => [
                    'Oui' => 'oui',
                    'Non' => 'non'],
                'required'=>true
            ])
            ->add('at4jnbh',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
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
