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
use App\Form\FinContratType;
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
     * @Route("/VerifInfosPerso/{mailasso}/{but}/{role}/{Page1}/{Page2}", name="VerifInfosPerso")
     * @param Request $request
     * @param $mailasso
     * @param $role
     * @return Response
     */

    public function VerifInfosPerso($mailasso, $but, $role, Request $request, $Page1, $Page2)
    {
        $NewInfosPerso = new SalarieInfosPerso();
        $form = $this->createForm(VerifInfosPersoType::class, $NewInfosPerso);
        $form->handleRequest($request);
        $Page3='Ajouter un salarié';

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
            'but'=> $but,
            'ListeInfoAVerif' => $ListeInfoAVerif,
            'mailasso' => $mailasso,
            'role'=>$role,
            'Page1'=>$Page1,
            'Page2'=>$Page2,
            'Page3'=>$Page3
        ]);
    }

    /**
     * @Route("/AjoutInfosPerso/{mailasso}/{role}/{but}/{Page1}", name="AjoutInfosPerso")
     * @param $mailasso
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function AjoutInfosPerso($mailasso, $role, $but, Request $request, EntityManagerInterface $entityManager, $Page1) {
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
            //je redirecte vers page ou route
            return $this->redirectToRoute('AjoutInfosPro', [
                'idinfoperso' => $idinfosPerso,
                'mailasso' => $mailasso,
                'but' => $but,
                'role' => $role,
                'Page1'=>$Page1
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso,
                'but' => $but,
                'role'=>$role,
                'Page1'=>$Page1
            ]);
        }
    }

    /*######################## SALARIE INFOS PRO ########################*/

    /**
     * @Route("/AjoutInfosPro/{mailasso}/{idinfoperso}/{role}/{but}/{Page1}", name="AjoutInfosPro")
     * @param $idinfoperso
     * @param $mailasso
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function AjoutInfosPro($mailasso, $idinfoperso, $role, $but, Request $request, EntityManagerInterface $entityManager, $Page1) {
        //trouve l'entité salaireinfoperso à partir de lid
        $salarieinfoperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idinfoperso);
        //on trouve l'association avec le mail asso
        $association=$this->getDoctrine()->getRepository(Association::class)->find($mailasso);

        //on vérifie que dnas la liste des salaireinfosperso dnas association le salairé ne soit pas déjà lié à l'asso
        $listeInfosPerso=$association->getsalarieinfosperso(); //liste des entités de salarieinfosperso lié à l'asso
        $existe='non';
        //boucle for pour parcourir la liste
        for ($i=0; $i <= count($listeInfosPerso); $i++){
            if ($listeInfosPerso[$i]==$salarieinfoperso){
                $existe='oui';
            }
        }
        //s'il est pas lié --> on le lie (des deux coter)
        if ($existe=='non'){
            $salarieinfoperso->addAssociation($association);
            $association->addSalarieinfosperso($salarieinfoperso);
        }
        //s'il est lié on passe à la suite

        //je crée un objet InfosPro
        $InfosPro = new SalarieInfosPro();
        //je mets automatiquement le champs smailasso=mailasso
        $InfosPro->setSmailasso($mailasso);
        //je mets automatiquement le champs sinfoperso=idinfoperso
        $InfosPerso = $this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idinfoperso);

        ///////////////////////////////////////////
        //je donne un formulaire avec les champs de la table SalarieInfosPro
        $form = $this->createForm(AjoutInfosProType::class, $InfosPro);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){
            //j'enregistre les nouvelles infos perso dans la bdd
            $InfosPro->setSPersoId($InfosPerso);
            $InfosPerso->addSalarieinfospro($InfosPro);

            $entityManager->persist($InfosPro);
            $entityManager->flush();
            //je redirecte vers page ou route
            if ($role=='SUPER_ADMIN'){
                $Page1= 'Liste des associations';
                $Page2= 'Liste des salariés';
                return $this->redirectToRoute('affSalaries',[
                    'assomail'=>$mailasso,
                    'Page1'=>$Page1,
                    'Page2'=>$Page2,
                    'but'=>$but
                ]);
            }
            elseif ($role=='ADMIN_ASSO'){
                return $this->redirectToRoute('ListeSalaries',[
                    'Page1'=>$Page1,
                ]);
            }
        }
        else{
            return $this->render('Commun/AjoutInfosPro.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso,
                'idinfosperso' => $idinfoperso,
                'Page1'=>$Page1,
                'but'=>$but
            ]);
        }
    }

    /*######################## GESTION DES SALARIES ########################*/

    /**
     * @Route("/GestionSalarie/{but}/{assoMail}/{idsalarie}/{idinfospro}/{Page1}/{Page2}", name="GestionSalarie")
     */
    public function GestionSalarie($but, $assoMail, $idsalarie, $idinfospro, $Page1, $Page2) {
        $infosPro= $this -> getDoctrine() -> getRepository(SalarieInfosPro::class) -> find($idinfospro);
        $Conges= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $infosPro]);
        $ArretTravails= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $infosPro]);
        $Chomages= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $infosPro]);
        $AutresAbsences= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $infosPro]);
        $Primes= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $infosPro]);
        $Frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $infosPro]);
        $Heures= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $infosPro]);
        $Avenants= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $infosPro]);
        $Page3 = 'Gestion des informations';

        return $this->render('Commun/GestionSalaries.html.twig', [ // renvoie vers le twig qui affiche les options de gestion du salarié
            'but'=>$but,
            'assoMail'=>$assoMail,
            'idinfospro' => $idinfospro,
            'idsalarie'=> $idsalarie,
            'conges' => $Conges,
            'arrettravails' => $ArretTravails,
            'chomages' => $Chomages,
            'autresabsences' => $AutresAbsences,
            'primes' => $Primes,
            'frais' => $Frais,
            'heures' => $Heures,
            'avenants' => $Avenants,
            'Page1' => $Page1,
            'Page2' => $Page2,
            'Page3' => $Page3,
            'infosPro' => $infosPro
        ]);
    }


    /*######################## CONGES ########################*/

    /**
     * @Route("/EnregistrerConge/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerConge")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerConge(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
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
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }

        } else {
            return $this->render('Commun/AjoutConges.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=> $Page1,
                'Page2'=> $Page2
            ]);
        }
    }

    /**
     * @Route("/modifConge/{sproid}/{idconge}/{butForReturn}/{Page1}/{Page2}", name="modifConge")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifConge(Request $request,EntityManagerInterface $entityManager,$sproid, $idconge, $butForReturn, $Page1, $Page2){
        $conge=$this->getDoctrine()->getRepository(Conges::class)->find($idconge);
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $conge->setSproid($InfosPro);
        //je crée un formulaire avec les champs de l'entité conge
            $form=$this->createForm(CongesType::class, $conge);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                $entityManager->persist($conge);
                $entityManager->flush();
                //je redirecte vers page ou route en fonction du butForReturn :
                if ($butForReturn=='SUPER_ADMIN_SEUL'){
                    $assoMail=$InfosPro->getSmailasso();
                    $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                    return $this->redirectToRoute('voirSalarie', [
                        'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                        'assoMail'=> $assoMail, //id de l'association
                        'but'=> 'association',
                        'Page1'=>$Page1,
                        'Page2'=>$Page2
                    ]);
                }
                elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                    $assoMail=$InfosPro->getSmailasso();
                    $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                    return $this->redirectToRoute('GestionSalarie', [
                        'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                        'assoMail'=> $assoMail, //id de l'association
                        'but'=> 'salarie',
                        'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                        'Page1'=> $Page1,
                        'Page2'=> $Page2
                    ]);
                }
                elseif ($butForReturn=='ADMIN_ASSO'){
                    $assoMail=$InfosPro->getSmailasso();
                    $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                    return $this->redirectToRoute('ProfilSalarie', [
                        'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                        'idmail'=> $assoMail, //id de l'association
                        'Page1'=> $Page1,
                    ]);
                }
            }
            else{
                return $this->render('Commun/AjoutConges.html.twig', [
                    'form' => $form->createView(),
                    'infosconge'=>$conge,
                    'idpro'=>$sproid,
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }

    }

    /*######################## ARRET TRAVAIL  ########################*/

    /**
     * @Route("/EnregistrerArretTravail/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerArretTravail")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerArretTravail(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
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
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutArretTravail.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifArretTravail/{sproid}/{idarrettravail}/{butForReturn}/{Page1}/{Page2}", name="modifArretTravail")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @param $idarrettravail
     * @param $butForReturn
     * @return Response
     */
    public function modifArretTravail(Request $request,EntityManagerInterface $entityManager,$sproid, $idarrettravail,$butForReturn, $Page1, $Page2)
    {
        $arrettravail = $this->getDoctrine()->getRepository(ArretTravail::class)->find($idarrettravail);
        //je crée un formulaire avec les champs de l'entité arrettravail
        $form = $this->createForm(ArretTravailType::class, $arrettravail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($arrettravail);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutArretTravail.html.twig', [
                'form' => $form->createView(),
                'infosarrettravail' => $arrettravail,
                'idpro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /*######################## CHOMAGE ########################*/

    /**
     * @Route("/EnregistrerChomage/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerChomage")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerChomage(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
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
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutChomage.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifChomage/{sproid}/{idchomage}/{butForReturn}/{Page1}/{Page2}", name="modifChomage")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifChomage(Request $request,EntityManagerInterface $entityManager,$sproid, $idchomage, $butForReturn, $Page1, $Page2){
        $chomage=$this->getDoctrine()->getRepository(Chomage::class)->find($idchomage);
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $chomage->setSproid($InfosPro);
        //je crée un formulaire avec les champs de l'entité chomage
        $form=$this->createForm(ChomageType::class, $chomage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($chomage);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfosperso
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        }
        else{
            return $this->render('Commun/AjoutChomage.html.twig', [
                'form' => $form->createView(),
                'infoschomage'=>$chomage,
                'idpro'=>$sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }

    }
    /*######################## AUTRE ABSENCE ########################*/

    /**
     * @Route("/EnregistrerAutreAbsence/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerAutreAbsence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerAutreAbsence(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
    {
        //je veux ajouter des informations dans ma table autreabsencesymfony
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
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutAutreAbsence.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifAutreAbsence/{sproid}/{idautreabsence}/{butForReturn}/{Page1}/{Page2}", name="modifAutreAbsence")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifAutreAbsence(Request $request,EntityManagerInterface $entityManager,$sproid, $idautreabsence, $butForReturn, $Page1, $Page2)
    {
        $autreabsence = $this->getDoctrine()->getRepository(AutreAbsence::class)->find($idautreabsence);
        //je crée un formulaire avec les champs de l'entité autreabsence
        $form = $this->createForm(AutreAbsenceType::class, $autreabsence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autreabsence);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutAutreAbsence.html.twig', [
                'form' => $form->createView(),
                'infosautreabsence' => $autreabsence,
                'idpro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }
    /*######################## PRIME ########################*/

    /**
     * @Route("/EnregistrerPrime/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerPrime")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerPrime(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
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
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }

        } else {
            return $this->render('Commun/AjoutPrime.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifPrime/{sproid}/{idprime}/{butForReturn}/{Page1}/{Page2}", name="modifPrime")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifPrime(Request $request,EntityManagerInterface $entityManager,$sproid, $idprime, $butForReturn, $Page1, $Page2){
        $prime=$this->getDoctrine()->getRepository(Prime::class)->find($idprime);
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $prime->setSproid($InfosPro);
        //je crée un formulaire avec les champs de l'entité prime
        $form=$this->createForm(PrimeType::class, $prime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($prime);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        }
        else{
            return $this->render('Commun/AjoutPrime.html.twig', [
                'form' => $form->createView(),
                'infosprime'=>$prime,
                'idpro'=>$sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }

    }

    /*######################## FRAIS ########################*/

    /**
     * @Route("/EnregistrerFrais/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerFrais")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerFrais(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
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


        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre le nouveau frais dans la bdd

            $entityManager->persist($frais);
            $entityManager->flush();
            // on veut entrer le total (quantité*taux) dans la bdd
            //je recupère la quantité de mon frais
            $fraquantite = $frais->getFraquantite();
            //je récupère le taux de mon frais
            $frataux = $frais->getFrataux();
            //je fais le calcul que je mets dans une variable $total
            $total = $fraquantite*$frataux;
            //j'ajoute mon résulté dans ma variable de l'entité frais
            $frais->setFratotal($total);

            //j'enregistre le nouveau frais (avec le total) dans la bdd
            $entityManager->persist($frais);
            $entityManager->flush();

            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutFrais.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }
    /**
     * @Route("/modifFrais/{sproid}/{idfrais}/{butForReturn}/{Page1}/{Page2}", name="modifFrais")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifFrais(Request $request,EntityManagerInterface $entityManager,$sproid, $idfrais, $butForReturn, $Page1, $Page2)
    {
        $frais = $this->getDoctrine()->getRepository(Frais::class)->find($idfrais);
        //je crée un formulaire avec les champs de l'entité frais
        $form = $this->createForm(FraisType::class, $frais);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($frais);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutFrais.html.twig', [
                'form' => $form->createView(),
                'infosfrais' => $frais,
                'idpro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }
    /*######################## AVENANTS ########################*/

    /**
     * @Route("/EnregistrerAvenant/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerAvenant")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerAvenant(Request $request, EntityManagerInterface $entityManager, $sproid,$butForReturn, $Page1, $Page2)
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
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutAvenant.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifAvenant/{sproid}/{idavenant}/{butForReturn}/{Page1}/{Page2}", name="modifAvenant")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifAvenant(Request $request,EntityManagerInterface $entityManager,$sproid, $idavenant, $butForReturn, $Page1, $Page2)
    {
        $avenant = $this->getDoctrine()->getRepository(Avenant::class)->find($idavenant);
        //je crée un formulaire avec les champs de l'entité avenant
        $form = $this->createForm(AvenantType::class, $avenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avenant);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du ButToReturn
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        } else {
            return $this->render('Commun/AjoutAvenant.html.twig', [
                'form' => $form->createView(),
                'infosavenant' => $avenant,
                'idpro' => $sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }


    /*######################## HEURES ########################*/

    /**
     * @Route("/EnregistrerHeures/{sproid}/{butForReturn}/{Page1}/{Page2}", name="EnregistrerHeures")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function EnregistrerHeures(Request $request, EntityManagerInterface $entityManager, $sproid, $butForReturn, $Page1, $Page2)
    {
        //je veux ajouter des informations dans ma table heure
        //liée cette table à la table connexion précédente

        //je crée un objet heure
        $heure = new Heures();
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $heure->setSproid($InfosPro);
        // je récupère le type temps de travail de l'entité salarie info pro
        $type = $InfosPro->getStypetempstravail();

        //je donne un formulaire avec les champs de la table heure
        $form = $this->createForm(HeuresType::class, $heure);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()) {
            //j'enregistre la nouvelle prime dans la bdd
            $entityManager->persist($heure);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }

        } else {
            return $this->render('Commun/AjoutHeures.html.twig', [
                'form' => $form->createView(),
                'idinfospro' => $sproid,
                'typetravail' => $type,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/modifHeure/{sproid}/{idheure}/{butForReturn}/{Page1}/{Page2}", name="modifHeure")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @return Response
     */
    public function modifHeure(Request $request,EntityManagerInterface $entityManager,$sproid, $idheure, $butForReturn, $Page1, $Page2){
        $heure=$this->getDoctrine()->getRepository(Heures::class)->find($idheure);

        // je récupère le type temps de travail de l'entité salarie info pro
        $InfosPro = $this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);
        $type = $InfosPro->getStypetempstravail();

        //je crée un formulaire avec les champs de l'entité heure
        $form=$this->createForm(HeuresType::class, $heure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($heure);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$InfosPro->getSmailasso();
                $idsalarieperso=$InfosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        }
        else{
            return $this->render('Commun/AjoutHeures.html.twig', [
                'form' => $form->createView(),
                'infosheure'=>$heure,
                'idpro'=>$sproid,
                'typetravail' => $type,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }

    }

    /*######################## FIN DE CONTRAT  ########################*/

    /**
     * @Route("/modifFin/{sproid}/{butForReturn}/{Page1}/{Page2}", name="modifFin")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $sproid
     * @param $butForReturn
     * @param $Page1
     * @param $Page2
     * @return Response
     */
    public function modifFin(Request $request,EntityManagerInterface $entityManager,$sproid, $butForReturn, $Page1, $Page2){
        $infosPro=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($sproid);


        //je crée un formulaire avec les champs de l'arret de travail
        $form=$this->createForm(FinContratType::class, $infosPro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infosPro);
            $entityManager->flush();
            //je redirecte vers page ou route en fonction du butForReturn :
            if ($butForReturn=='SUPER_ADMIN_SEUL'){
                $assoMail=$infosPro->getSmailasso();
                $idsalarieperso=$infosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('voirSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'association',
                    'Page1'=>$Page1,
                    'Page2'=>$Page2
                ]);
            }
            elseif ($butForReturn=='SUPER_ADMIN_PLUS'){
                $assoMail=$infosPro->getSmailasso();
                $idsalarieperso=$infosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('GestionSalarie', [
                    'idsalarie'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'assoMail'=> $assoMail, //id de l'association
                    'but'=> 'salarie',
                    'idinfospro'=>$sproid, //id de l'entite salarioinfospro
                    'Page1'=> $Page1,
                    'Page2'=> $Page2
                ]);
            }
            elseif ($butForReturn=='ADMIN_ASSO'){
                $assoMail=$infosPro->getSmailasso();
                $idsalarieperso=$infosPro->getSPersoId()->getSpersoid();
                return $this->redirectToRoute('ProfilSalarie', [
                    'idPerso'=>$idsalarieperso, //id de l'entite salarioinfosperso
                    'idmail'=> $assoMail, //id de l'association
                    'Page1'=> $Page1,
                ]);
            }
        }
        else{
            return $this->render('Commun/ModifFinContrat.html.twig', [
                'form' => $form->createView(),
                'infosPro'=>$infosPro,
                'idpro'=>$sproid,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }

    }
}