<?php

namespace App\Controller;
use App\Entity\ArretTravail;
use App\Entity\Association;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Prime;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\ArretTravailType;
use App\Form\ChomageType;
use App\Form\CongesType;
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
        //je mets automatiquement le champs aMail=mailasso
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
            //je redirecte vers page ou route
            if ($role=='SUPER_ADMIN'){
                return $this->redirectToRoute('affSalaries',[
                    'assomail'=>$mailasso
                ]);
            }
            elseif ($role=='ADMIN_ASSO'){
                return $this->redirectToRoute('home',[
                ]);
            }

        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'mailasso'=> $mailasso
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
}