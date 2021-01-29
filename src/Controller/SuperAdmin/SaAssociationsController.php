<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Association;
use App\Entity\Connexion;
use App\Form\AssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaAssociationsController extends AbstractController
{
    /**
     * @Route("/affAssociation/{but}", name="affAssociation")
     * @param $but
     * @return Response
     */
    public function affAssociation($but){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        //si mon but est de gérer les association alors on renvoi vers la page affAllAsso
        if ($but=="assos"){
            return $this->render('SuperAdmin/affAllAssociations.html.twig', [
                'associations' => $associations,
            ]);
        }
        //si mon but est de gérer les salariés alors on renvoi vers la page affassosalaries
        elseif ($but=="salaries"){
            return $this->render('SuperAdmin/affAllAssociationsSalaries.html.twig', [
                'associations' => $associations,
            ]);
        }
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
        //je mets automatiquement le champs aMail=coMail
        $asso->setAmail($comail);
        //je donne un formulaire avec les champs de la table association
        $form=$this->createForm(AssociationType::class, $asso);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){

            //on lie l'association à la connexion en passant par le addAssociation dans connexion
            $connexion=$this->getDoctrine()->getRepository(Connexion::class)->find($comail);
            $connexion->addAssociation($asso);
            //on lie la connexion à l'association en passant par le addConnexion dans association
            $asso->addConnexion($connexion);

            //j'enregistre la nouvelle asso dans la bdd
            $entityManager->persist($asso);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('affAssociation',[
                'but'=>'assos'
            ]);
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
     * @param $assomail
     * @return Response
     */
    public function voirAssociation($assomail){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        return $this->render('SuperAdmin/affAssociation.html.twig', [
            'association' => $association
        ]);
    }

    /**
     * @Route("/modifAssociation{assoMail}", name="modifAssociation")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $assoMail
     * @return RedirectResponse|Response
     */
    public function modifAssociation(Request $request,EntityManagerInterface $entityManager,$assoMail){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assoMail);
        $form=$this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($association);
            $entityManager->flush();
            return $this->redirectToRoute('affAssociation',[
                'but'=>'assos'
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'assoMail'=> $assoMail
            ]);
        }
    }

    /**
     * @Route("/Choixasso/{role}", name="Choixasso")
     * @param $role
     * @return Response
     */
    public function Choixasso($role){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        return $this->render('SuperAdmin/choixAssociations.html.twig', [
            'associations' => $associations,
            'role'=>$role
        ]);
    }

}
