<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amail', EmailType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('anom', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aadresse', TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('atel', TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('adatecreation', DateType::class, [
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' =>'form-control']
            ])
            ->add('adateembauche', DateType::class, [
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' =>'form-control']
            ])
            ->add('afederation',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('asiret',IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aape',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aurssaf',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acoderisque',IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('atauxaccidenttravail', NumberType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apeidentifiant',IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apecodeperso',IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acaisseretraite',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acaisseretraitenumadh',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acaisseprevoyance',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('app',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('ap0',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acomplementaire',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acomplementaireadh',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aicom',IntegerType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aasstv',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apresnom',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apresadresse',TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apresportable',TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('aprestel',TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('apresmail',EmailType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('agestionnom', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acorrespondadresse',TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acorrespondportable',TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acorrespondtel',TelType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acorrespondmail',EmailType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('acourriersinternet')
            ->add('aenvoicourrier')
            ->add('amodepaiement')
            ->add('arib',TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('ainfocomplementaire',TextareaType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('adateadhesion',DateType::class,[
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' => 'form-control']
            ])
            //->add('salarieinfosperso') collection de salarieinfosperso
            //->add('comail') collection de connexion
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Association::class,
        ]);
    }
}
