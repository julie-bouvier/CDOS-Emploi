<?php

namespace App\Form;

use App\Entity\Association;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('anom', TextType::class)
            ->add('aadresse', TextareaType::class)
            ->add('atel', TelType::class)
            ->add('adatecreation', DateType::class, ['format'=> 'dd-MM-yyyy'])
            ->add('adateembauche', DateType::class, ['format'=> 'dd-MM-yyyy'])
            ->add('afederation')
            ->add('asiret')
            ->add('aape')
            ->add('aurssaf')
            ->add('acoderisque')
            ->add('atauxaccidenttravail')
            ->add('apeidentifiant')
            ->add('apecodeperso')
            ->add('acaisseretraite')
            ->add('acaisseretraitenumadh')
            ->add('acaisseprevoyance')
            ->add('app')
            ->add('ap0')
            ->add('acomplementaire')
            ->add('acomplementaireadh')
            ->add('aicom')
            ->add('aasstv')
            ->add('apresnom')
            ->add('apresadresse')
            ->add('apresportable')
            ->add('aprestel')
            ->add('apresmail')
            ->add('agestionnom')
            ->add('acorrespondadresse')
            ->add('acorrespondportable')
            ->add('acorrespondtel')
            ->add('acorrespondmail')
            ->add('acourriersinternet')
            ->add('aenvoicourrier')
            ->add('amodepaiement')
            ->add('arib')
            ->add('ainfocomplementaire')
            ->add('adateadhesion')
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
