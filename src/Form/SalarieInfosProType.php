<?php

namespace App\Form;

use App\Entity\SalarieInfosPro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarieInfosProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('snomemployeur')
            ->add('smailasso')
            ->add('sposteoccupe')
            ->add('sccns')
            ->add('snaturecontrat')
            ->add('stypetempstravail')
            ->add('sgestcp')
            ->add('sdatedebut')
            ->add('sdatefin')
            ->add('sfinmotif')
            ->add('s10congemois')
            ->add('sconge')
            ->add('stypecontrat')
            ->add('smultiemployeur')
            ->add('svolhorairemois')
            ->add('stauxhorairebrut')
            ->add('ssalmoisbrut')
            ->add('scomplemsante')
            ->add('sautreelement')
            ->add('scomfin')
            //->add('sPersoId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SalarieInfosPro::class,
        ]);
    }
}
