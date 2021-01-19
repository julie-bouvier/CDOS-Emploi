<?php

namespace App\Form;

use App\Entity\Connexion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comail', EmailType::class)
            ->add('comdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Répéter le même mot de passe',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe : '],
                'second_options' => ['label' => 'Répéter le mot de passe : '],
            ])
            ->add('coroles', ChoiceType::class, [
                'choices' => [
                    'Admin Association' => 'ROLE_ADMIN',
                    'Super Administrateur' => 'ROLE_SUPER_ADMIN'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Connexion::class,
        ]);
    }
}
