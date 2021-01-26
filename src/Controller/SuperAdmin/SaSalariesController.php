<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Association;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\SalarieInfosPersoType;
use App\Form\SalarieInfosProType;
use App\Form\VerifInfosPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaSalariesController extends AbstractController
{
    /*######################## AFFICHAGE SALARIE ########################*/
    /**
     * @Route("/affSalaries/{assomail}", name="affSalaries")
     */
    public function affSalaries($assomail){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        $listsalaries=$association->getsalarieinfosperso();

        if (empty($listsalaries)){
            $message='Il n\'y a pas de salariés enregistrés dans cette association';
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'message' => $message,
                'assoMail' => $assomail
            ]);
        }
        else{
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'listsalaries' => $listsalaries,
                'assoMail' => $assomail
            ]);
        }
    }

    /**
     * @Route("/voirSalaries/{idsalarie}", name="voirSalaries")
     * @param $idsalarie
     * @return Response
     */
    public function voirSalaries($idsalarie){
        $salarie=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
        $associations=$salarie->getAmail();
        $infospros=$salarie->getSproid();
        return $this->render('SuperAdmin/affSalarie.html.twig', [
            'salarie' => $salarie,
            'associations'=>$associations,
            'infospros'=>$infospros
        ]);
    }

    /*######################## SALARIE INFOS PRO ########################*/

    /**
     * @Route("/modifSalariesPro/{idInfoProSalarie}/{idSalarie}", name="modifSalariesPro")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idInfoProSalarie
     * @param $idSalarie
     * @return Response
     */
    public function modifSalariesPro(Request $request,EntityManagerInterface $entityManager,$idInfoProSalarie, $idSalarie){
        $infospros=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($idInfoProSalarie);
        $form=$this->createForm(SalarieInfosProType::class, $infospros);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infospros);
            $entityManager->flush();
            return $this->redirectToRoute('voirSalaries',[
                'idsalarie'=>$idSalarie
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutSalarieInfosPro.html.twig', [
                'form' => $form->createView(),
                'idInfoProSalarie'=> $idInfoProSalarie,
                'idSalarie'=>$idSalarie
            ]);
        }
    }

    /*######################## SALARIE INFOS PERSO ########################*/

    /**
     * @Route("/modifSalariesPerso/{idSalarie}", name="modifSalariesPerso")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idSalarie
     * @return Response
     */
    public function modifSalariesPerso(Request $request,EntityManagerInterface $entityManager, $idSalarie){
        $infosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idSalarie);
        $form=$this->createForm(AjoutInfosPersoType::class, $infosperso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infosperso);
            $entityManager->flush();
            return $this->redirectToRoute('voirSalaries',[
                'idsalarie'=>$idSalarie
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'idSalarie'=>$idSalarie
            ]);
        }
    }
}