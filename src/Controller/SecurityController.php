<?php

namespace App\Controller;

use App\Entity\Connexion;
use App\Form\ConnexionType;
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
        $connexion=new Connexion();
        $form=$this->createForm(ConnexionType::class, $connexion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //Hasher le password
            $hash = $encoder->encodePassword($connexion, $connexion->getPassword());
            $connexion->setPassword($hash);

            $entityManager->persist($connexion);
            $entityManager->flush();
            return $this->redirectToRoute('home');

        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/login",name="login")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route ("/logout", name="logout")
     */
    public function logout(){}
}
