<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aadresse', TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('atel', TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('adatecreation', DateType::class, [
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' =>'form-control'],
                'required'=>false
            ])
            ->add('adateembauche', DateType::class, [
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' =>'form-control'],
                'required'=>false
            ])
            ->add('afederation',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('asiret',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aape',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aurssaf',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acoderisque',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('atauxaccidenttravail', NumberType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apeidentifiant',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apecodeperso',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acaisseretraite',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acaisseretraitenumadh',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acaisseprevoyance',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('app',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('ap0',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acomplementaire',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acomplementaireadh',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aicom',IntegerType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aasstv',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apresnom',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apresadresse',TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apresportable',TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('aprestel',TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('apresmail',EmailType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('agestionnom', TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acorrespondadresse',TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acorrespondportable',TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acorrespondtel',TelType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acorrespondmail',EmailType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('acourriersinternet', CheckboxType::class)
            ->add('aenvoicourrier',ChoiceType::class, [
                'choices' => [
                    'du correspondant' => 'correspondant',
                    'de l\'associaion' => 'association'
                ],
                'attr' => ['class' => 'form-control']
            ])

            ->add('amodepaiement',ChoiceType::class, [
                'choices' => [
                    'virement' => 'virement',
                    'chèque' => 'cheque',
                    'espèce' => 'espece'
                ],
                'attr' => ['class' => 'form-control']
            ])


            ->add('arib',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('ainfocomplementaire',TextareaType::class,[
                'attr' => ['class' => 'form-control'],
                'required'=>false
            ])
            ->add('adateadhesion',DateType::class,[
                'format'=> 'dd-MM-yyyy',
                'attr' => ['class' => 'form-control'],
                'required'=>false
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
