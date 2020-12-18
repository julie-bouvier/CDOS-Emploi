<?php

namespace App\Controller;

use App\Entity\Connexion;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $connexion=new Connexion();         //on crée la variable connexion
        $form=$this->createForm(RegistrationType::class, $connexion);           //on crée le form en utilisant le form RegistrationType

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){                              //si le form est valide
            $hash = $encoder->encodePassword($connexion, $connexion->getPassword());    //on hashe le mdp: recupere+hash
            $connexion->setPassword($hash);                                             //on lie le mdp hashé à la variable connexio
            $entityManager->persist($connexion);
            $entityManager->flush();                                                    //persist+flush : les informations sont misent à jour dans la bdd
            return $this->redirectToRoute('home');                                     //on retourne à la page home

        }

        return $this->render('security/registration.html.twig', [                       //si mal  rempli : on retourne registration (on reste sur ce formulaire)
            'form' => $form->createView()                                           //on renvoie au formulairee
        ]);
    }
}
