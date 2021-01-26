<?php

namespace App\Controller;

use App\Entity\ArretTravail;
use App\Entity\AutreAbsence;
use App\Entity\Avenant;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Frais;
use App\Entity\Heures;
use App\Entity\Prime;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\ChomageType;
use App\Form\CongesType;
use App\Form\VerifInfosPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association;
use App\Entity\Connexion;



class AdminController extends AbstractController
{

    /**
     * @Route("/ListeSalaries", name="ListeSalaries")
     */

    public function ListeSalaries() {
        $MailPersoConnecte= $this -> getUser() -> getUsername();
        $PersoConnecte = $this -> getDoctrine() -> getRepository(Connexion::class) -> find($MailPersoConnecte);
        $Associations = $PersoConnecte -> getassociations();
        //boucle qui va tourner dans la collection d'associations
        //pour chaque association :
        for ($i=0; $i <= count($Associations); $i++)
        {
            //if c'est pas null
            if($Associations[$i]!=null){
                $ListeSalaries = $Associations[$i] -> getsalarieinfosperso();
                $MailAsso = $Associations[$i] -> getAmail();
            }
        }
        // renvoie vers le twig affichant la liste des salariés
        return $this->render('admin/ListeSalaries.html.twig', [ // renvoie vers le twig de la liste des salariés
            'associations'=> $Associations,
            'ListeSalaries' => $ListeSalaries,
            'MailAsso'=> $MailAsso,
        ]);
    }

    /**
     * @Route("/ProfilSalarie/{id}/{idmail}", name="ProfilSalarie")
     */

    public function ProfilSalarie($id, $idmail) {
        $InfosPerso = $this -> getDoctrine() -> getRepository(SalarieInfosPerso::class) -> find($id);
        $InfosPro = $InfosPerso -> getSproid();

        for ($i=0; $i <= count($InfosPro); $i++)
        {
            if($InfosPro[$i]!=null){
                $InfoProMailAsso = $InfosPro[$i] -> getSmailasso();
                if($InfoProMailAsso==$idmail){

                    $IdInfosPro = $InfosPro[$i] -> getSproid();
                    $InfosProAsso = $this -> getDoctrine() -> getRepository(SalarieInfosPro::class) -> find($IdInfosPro);

                    return $this->render('admin/ProfilSalaries.html.twig', [ // renvoie vers le twig qui affiche les infos pros et perso du salarié
                        'infosperso' => $InfosPerso,
                        'infospro' => $InfosProAsso
                    ]);
                }
            }
        }
    }

    /**
     * @Route("/GestionSalarie/{idinfospro}", name="GestionSalarie")
     */

    public function GestionSalarie($idinfospro) {
        $Conges= $this -> getDoctrine() -> getRepository(Conges::class) -> findby($idinfospro);
        $ArretTravails= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> find($idinfospro);
        $Chomages= $this -> getDoctrine() -> getRepository(Chomage::class) -> find($idinfospro);
        $AutresAbsences= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> find($idinfospro);
        $Primes= $this -> getDoctrine() -> getRepository(Prime::class) -> find($idinfospro);
        $Frais= $this -> getDoctrine() -> getRepository(Frais::class) -> find($idinfospro);
        $Heures= $this -> getDoctrine() -> getRepository(Heures::class) -> find($idinfospro);
        $Avenants= $this -> getDoctrine() -> getRepository(Avenant::class) -> find($idinfospro);

        return $this->render('admin/GestionSalaries.html.twig', [ // renvoie vers le twig qui affiche les options de gestion du salarié
            'idinfospro' => $idinfospro,
            'conges' => $Conges,
            'arrettravails' => $ArretTravails,
            'chomages' => $Chomages,
            'autresabsences' => $AutresAbsences,
            'primes' => $Primes,
            'frais' => $Frais,
            'heures' => $Heures,
            'avenants' => $Avenants
        ]);
    }


    /**
     * @Route("/VerifInfosPerso/{mailasso}", name="VerifInfosPerso")
     */

    public function VerifInfosPerso($mailasso, Request $request)
    {

        $NewInfosPerso = new SalarieInfosPerso();
        $form = $this->createForm(VerifInfosPersoType::class, $NewInfosPerso);
        $form->handleRequest($request);

        //Creation du tableau des Informations a vérifier qui est vide
        $ListeInfoAVerif = [];

        if ($form->isSubmitted() && $form->isValid()) {
            //On récupère le numéro de sécu du salarié tapé dans le formulaire
            $numsecu = $NewInfosPerso->getSnumsecu();
            if ($numsecu != null)
                $ListeInfoAVerif = $this->getDoctrine()->getRepository(SalarieInfosPerso::class)->findBy(['snumsecu' => $numsecu]);
        }

        return $this->render('admin/RechercheInfosPerso.html.twig', [
            'form' => $form->createView(),
            'ListeInfoAVerif' => $ListeInfoAVerif,
            'mailasso' => $mailasso
        ]);
    }


    /**
     * @Route("/AjoutInfosPerso/{mailasso}", name="AjoutInfosPerso")
     */

    public function AjoutInfosPerso($mailasso, Request $request, EntityManagerInterface $entityManager) {
//je crée un objet InfosPerso
        $InfosPerso = new SalarieInfosPerso();
        //je mets automatiquement le champs aMail=mailasso
        $InfosPerso->setAmail($mailasso);
        //je donne un formulaire avec les champs de la table SalarieInfosPerso
        $form = $this->createForm(AjoutInfosPersoType::class, $InfosPerso);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){

            //j'enregistre les nouvelles infos perso dans la bdd
            $entityManager->persist($InfosPerso);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('/',[
            ]);
        }
        else{
            return $this->render('admin/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso
            ]);
        }

    }

    /**
     * @Route("/EnregistrerConge/{sproid}", name="EnregistrerConge")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerConge(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table conges
        //liée cette table à la table connexion précédente

        //je crée un objet conges
        $conge = new Conges();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $conge->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table conges
        $form = $this->createForm(CongesType::class, $conge);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {

            //j'enregistre le nouveau conge dans la bdd
            $entityManager->persist($conge);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('admin/AjoutConges.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }

    /**
     * @Route("/EnregistrerChomage/{sproid}", name="EnregistrerChomage")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerChomage(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table chomage
        //liée cette table à la table connexion précédente

        //je crée un objet chomage
        $chomage = new Chomage();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $chomage->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table conges
        $form = $this->createForm(ChomageType::class, $chomage);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {

            //j'enregistre le nouveau chomage dans la bdd
            $entityManager->persist($chomage);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('admin/AjoutChomage.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,

            ]);
        }
    }
}


