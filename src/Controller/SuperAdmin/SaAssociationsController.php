<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Association;
use App\Entity\Connexion;
use App\Entity\FAssociation;
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

        //on crée la page 1
        $Page1='Liste des associations';
        //si mon but est de gérer les association alors on renvoi vers la page affAllAsso
        if ($but=="association"){
            return $this->render('SuperAdmin/affAllAssociations.html.twig', [
                'associations' => $associations,
                'but'=> $but,
                'Page1' => $Page1
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
                'but'=>'association'
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
     * @Route("/voirAssociation/{but}/{assomail}/{Page1}", name="voirAssociation")
     * @param $assomail
     * @param $Page1
     * @return Response
     */
    public function voirAssociation($but, $assomail, $Page1){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        $Page2='Profil de l\'association';
        return $this->render('SuperAdmin/affAssociation.html.twig', [
            'association' => $association,
            'but'=> $but,
            'Page1'=>$Page1,
            'Page2'=>$Page2
        ]);
    }

    /**
     * @Route("/modifAssociation{assoMail}/{Page1}", name="modifAssociation")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $assoMail
     * @return RedirectResponse|Response
     */
    public function modifAssociation(Request $request,EntityManagerInterface $entityManager,$assoMail,$Page1){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assoMail);
        $form=$this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($association);
            $entityManager->flush();
            return $this->redirectToRoute('affAssociation',[
                'but'=>'association',
                'Page1'=>$Page1
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'assoMail'=> $assoMail,
                'Page1'=>$Page1
            ]);
        }
    }

    /**
     * @Route("/Choixasso/{role}/{Page1}", name="Choixasso")
     * @param $role
     * @return Response
     */
    public function Choixasso($role, $Page1){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        $Page2='Ajout : Choix d\'une association';
        $but='salarie';
        return $this->render('SuperAdmin/choixAssociations.html.twig', [
            'associations' => $associations,
            'but'=> $but,
            'role'=>$role,
            'Page1'=>$Page1,
            'Page2'=>$Page2
        ]);
    }
    /*########################EXPORT INFOS SALARIES #####################*/

    /**
     * @Route("/ExportInfosAsso", name="ExportInfosAsso")
     * @return Response
     */
    public function ExportInfosAsso(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();


        return $this->render('SuperAdmin/ExportInfosAssos.html.twig', [
            'associations'=>$associations,

        ]);

    }

    /*######################## Documents Salariés ########################*/

    /**
     * @Route("/OngletDocListeAssociations", name="OngletDocListeAssociations")
     */
    public function OngletDocListeAssociations(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();

            return $this->render('Commun/OngletDocListeAssociations.html.twig', [
                'associations' => $associations,
            ]);
    }

    /**
     * @Route("/ListeDocsAssociation/{amail}", name="ListeDocsAssociation")
     */
    public function ListeDocsAssociation($amail){
        $Asso=$this -> getDoctrine() -> getRepository(Association::class) -> find($amail);
        $docsAsso=$this -> getDoctrine() -> getRepository(FAssociation::class) -> findBy(['amail'=> $Asso]);

        return $this->render('Commun/ListeDocsAssociation.html.twig', [ // renvoie vers le twig de la liste des documents de l'asso
            'docsAsso'=> $docsAsso
        ]);
    }

}
