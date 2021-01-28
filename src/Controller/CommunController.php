<?php

namespace App\Controller;
use App\Entity\ArretTravail;
use App\Entity\Association;
use App\Entity\AutreAbsence;
use App\Entity\Avenant;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Heures;
use App\Entity\Frais;
use App\Entity\Prime;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\AjoutInfosProType;
use App\Form\ArretTravailType;
use App\Form\AutreAbsenceType;
use App\Form\AvenantType;
use App\Form\ChomageType;
use App\Form\CongesType;
use App\Form\HeuresType;
use App\Form\FraisType;
use App\Form\PrimeType;
use App\Form\SalarieInfosProType;
use App\Form\VerifInfosPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommunController extends AbstractController
{
    /*######################## SALARIE INFOS PERSO ########################*/

    /**
     * @Route("/VerifInfosPerso/{mailasso}/{role}", name="VerifInfosPerso")
     * @param Request $request
     * @param $mailasso
     * @param $role
     * @return Response
     */

    public function VerifInfosPerso($mailasso, $role, Request $request)
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

        return $this->render('Commun/RechercheInfosPerso.html.twig', [
            'form' => $form->createView(),
            'ListeInfoAVerif' => $ListeInfoAVerif,
            'mailasso' => $mailasso,
            'role'=>$role
        ]);
    }

    /**
     * @Route("/AjoutInfosPerso/{mailasso}/{role}", name="AjoutInfosPerso")
     * @param $mailasso
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function AjoutInfosPerso($mailasso, $role, Request $request, EntityManagerInterface $entityManager) {
        //je crée un objet InfosPerso
        $InfosPerso = new SalarieInfosPerso();
        //je li l'association à la bonne entité salarieinfosperso et inversement
        $association = $this->getDoctrine()->getRepository(Association::class)->find($mailasso);
        $InfosPerso->addAssociation($association);
        $association->addSalarieinfosperso($InfosPerso);

        //je donne un formulaire avec les champs de la table SalarieInfosPerso
        $form = $this->createForm(AjoutInfosPersoType::class, $InfosPerso);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){

            //j'enregistre les nouvelles infos perso dans la bdd
            $entityManager->persist($InfosPerso);
            $entityManager->flush();
            // Je récupère l'id perso pour l'envoyer à la page suivante pour l'ajout des infos pro
            $idinfosPerso = $InfosPerso ->getSpersoid();
            //$numsecu=$InfosPerso->getSnumsecu();
            //$newsalarieinfosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->findBy(['snumsecu'=>$numsecu]);
            //for ($i=0; $i <= 1; $i++){
                //$newidinfospro=$newsalarieinfosperso[$i]->getSpersoid();
            //}
            //je redirecte vers page ou route
            return $this->redirectToRoute('AjoutInfosPro', [
                'idinfoperso' => $idinfosPerso,
                'mailasso' => $mailasso,
                'role' => $role
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso,
                'role'=>$role
            ]);
        }
    }

    /*######################## SALARIE INFOS PERSO ########################*/

    /**
     * @Route("/AjoutInfosPro/{mailasso}/{idinfoperso}/{role}", name="AjoutInfosPro")
     * @param $idinfoperso
     * @param $mailasso
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function AjoutInfosPro($mailasso, $idinfoperso, $role, Request $request, EntityManagerInterface $entityManager) {
        //je crée un objet InfosPro
        $InfosPro = new SalarieInfosPro();
        //je mets automatiquement le champs smailasso=mailasso
        $InfosPro->setSmailasso($mailasso);
        //je mets automatiquement le champs sinfoperso=idinfoperso
        $InfosPerso = $this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idinfoperso);
        $InfosPro->setSPersoId($InfosPerso);
        $InfosPerso-> addSalarieinfospro($InfosPro);
        //je donne un formulaire avec les champs de la table SalarieInfosPro
        $form = $this->createForm(AjoutInfosProType::class, $InfosPro);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){
            //j'enregistre les nouvelles infos perso dans la bdd
            $entityManager->persist($InfosPro);
            $entityManager->flush();
            //je redirecte vers page ou route
            if ($role=='SUPER_ADMIN'){
                return $this->redirectToRoute('affSalaries',[
                    'assomail'=>$mailasso
                ]);
            }
            elseif ($role=='ADMIN_ASSO'){
                return $this->redirectToRoute('ListeSalaries',[
                ]);
            }

        }
        else{
            return $this->render('Commun/AjoutInfosPro.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso,
                'idinfosperso' => $idinfoperso
            ]);
        }
    }



    /*######################## CONGES ########################*/

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
            return $this->render('Commun/AjoutConges.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }


    /**
     * @Route("/modifConge/{sproid}/{idconge}", name="modifConge")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifConge(Request $request,EntityManagerInterface $entityManager,$sproid, $idconge){
        $conge=$this->getDoctrine()->getRepository(Conges::class)->find($idconge);
        //je crée un formulaire avec les champs de l'entité conge
            $form=$this->createForm(CongesType::class, $conge);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($conge);
                $entityManager->flush();
                return $this->redirectToRoute('GestionSalarie',[
                    'idinfospro'=>$sproid,
                ]);
            }
            else{
                return $this->render('Commun/AjoutConges.html.twig', [
                    'form' => $form->createView(),
                    'infosconge'=>$conge,
                    'idpro'=>$sproid
                ]);
            }

    }


    /*######################## ARRET TRAVAIL  ########################*/

    /**
     * @Route("/EnregistrerArretTravail/{sproid}", name="EnregistrerArretTravail")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerArretTravail(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table ArretTravail
        //lier cette table à la table InfosPro précédente

        //je crée un objet ArretTravail
        $arrettravail = new ArretTravail();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $arrettravail->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table arrettravail
        $form = $this->createForm(ArretTravailType::class, $arrettravail);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre le nouveau arrettravail dans la bdd
            $entityManager->persist($arrettravail);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('Commun/AjoutArretTravail.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,

            ]);
        }
    }

    /*######################## CHOMAGE ########################*/

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
            return $this->render('Commun/AjoutChomage.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }

    /**
     * @Route("/modifChomage/{sproid}/{idchomage}", name="modifChomage")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifChomage(Request $request,EntityManagerInterface $entityManager,$sproid, $idchomage){
        $chomage=$this->getDoctrine()->getRepository(Chomage::class)->find($idchomage);
        //je crée un formulaire avec les champs de l'entité chomage
        $form=$this->createForm(ChomageType::class, $chomage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($chomage);
            $entityManager->flush();
            return $this->redirectToRoute('GestionSalarie',[
                'idinfospro'=>$sproid,
            ]);
        }
        else{
            return $this->render('Commun/AjoutChomage.html.twig', [
                'form' => $form->createView(),
                'infoschomage'=>$chomage,
                'idpro'=>$sproid
            ]);
        }

    }
    /*######################## AUTRE ABSENCE ########################*/

    /**
     * @Route("/EnregistrerAutreAbsence/{sproid}", name="EnregistrerAutreAbsence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerAutreAbsence(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table autreabsence
        //liée cette table à la table connexion précédente

        //je crée un objet conges
        $autreabsence = new AutreAbsence();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $autreabsence->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table autreabsence
        $form = $this->createForm(AutreAbsenceType::class, $autreabsence);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre la nouvelle autreabsence dans la bdd
            $entityManager->persist($autreabsence);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('Commun/AjoutAutreAbsence.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }
    /*######################## PRIME ########################*/

    /**
     * @Route("/EnregistrerPrime/{sproid}", name="EnregistrerPrime")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerPrime(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table prime
        //liée cette table à la table connexion précédente

        //je crée un objet prime
        $prime = new Prime();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $prime->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table prime
        $form = $this->createForm(PrimeType::class, $prime);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre la nouvelle prime dans la bdd
            $entityManager->persist($prime);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);

        } else {
            return $this->render('Commun/AjoutPrime.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }
    /*######################## FRAIS ########################*/

    /**
     * @Route("/EnregistrerFrais/{sproid}", name="EnregistrerFrais")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerFrais(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table frais
        //liée cette table à la table connexion précédente

        //je crée un objet conges
        $frais = new Frais();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $frais->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table frais
        $form = $this->createForm(FraisType::class, $frais);
        $form->handleRequest($request);
        //$frais->setFratotal(($form.fraquantite)*($form.frataux));
        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre le nouveau frais dans la bdd

            $entityManager->persist($frais);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('Commun/AjoutFrais.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }
    /*######################## AVENANTS ########################*/

    /**
     * @Route("/EnregistrerAvenant/{sproid}", name="EnregistrerAvenant")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerAvenant(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table avenant
        //liée cette table à la table connexion précédente

        //je crée un objet avenant
        $avenant= new Avenant();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $avenant->setSproid($InfosPro);
        //je donne un formulaire avec les champs de la table avenant
        $form = $this->createForm(AvenantType::class, $avenant);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre le nouveau avenant dans la bdd

            $entityManager->persist($avenant);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);
        } else {
            return $this->render('Commun/AjoutAvenant.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
            ]);
        }
    }

    /*######################## HEURES ########################*/

    /**
     * @Route("/EnregistrerHeures/{sproid}", name="EnregistrerHeures")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerHeures(Request $request, EntityManagerInterface $entityManager, $sproid)
    {
        //je veux ajouter des informations dans ma table heure
        //liée cette table à la table connexion précédente

        //je crée un objet heure
        $heure = new Heures();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $heure->setSproid($InfosPro);

        $type = $InfosPro->getStypetempstravail();

        //je donne un formulaire avec les champs de la table heure
        $form = $this->createForm(HeuresType::class, $heure);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre la nouvelle prime dans la bdd
            $entityManager->persist($heure);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('GestionSalarie', [
                'idinfospro' => $sproid,
            ]);

        } else {
            return $this->render('Commun/AjoutHeures.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'typetravail' => $type,
            ]);
        }
    }
}