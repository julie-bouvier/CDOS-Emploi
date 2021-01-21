<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Association;
use App\Form\AssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaAssociationsController extends AbstractController
{
    /**
     * @Route("/affAssociation", name="affAssociation")
     */
    public function affAssociation(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        return $this->render('SuperAdmin/affAllAssociations.html.twig', [
            'associations' => $associations,
        ]);
    }

    /**
     * @Route("/EnregistrerAssociation/{comail}", name="EnregistrerAssociation")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $comail
     * @return Response
     */
    public function EnregistrerAssociation(Request $request,EntityManagerInterface $entityManager, $comail ){
        //je veux ajouter des informations dans ma table association
        //liée cette table à la table connexion précédente

        //je crée un objet association
        $asso=new Association();
        $asso->setAmail($comail);
        //je donne un formulaire avec les champs de la table association
        $form=$this->createForm(AssociationType::class, $asso);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){
            //je mets automatiquement le champs aMail=coMail

            //j'enregistre la nouvelle asso dans la bdd
            $entityManager->persist($asso);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('affAssociation',);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'comail'=> $comail
            ]);
        }
    }

    /**
     * @Route("/voirAssociation/{assomail}", name="voirAssociation")
     */
    public function voirAssociation($assomail){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        return $this->render('SuperAdmin/affAssociation.html.twig', [
            'association' => $association
        ]);
    }
}
