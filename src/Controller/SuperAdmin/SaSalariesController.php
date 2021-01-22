<?php

namespace App\Controller\SuperAdmin;

use App\Entity\Association;
use App\Entity\SalarieInfosPerso;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaSalariesController extends AbstractController
{
    /**
     * @Route("/affSalaries/{assomail}", name="affSalaries")
     */
    public function affSalaries($assomail){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        $listsalaries=$association->getsalarieinfosperso();

        if (empty($listsalaries)){
            $message='Il n\'y a pas de salariés enregistrés dans cette association';
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'message' => $message
            ]);
        }
        else{
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'listsalaries' => $listsalaries
            ]);
        }
    }

    /**
     * @Route("/voirSalaries/{idsalarie}", name="voirSalaries")
     * @param $idsalarie
     */
    public function voirSalaries($idsalarie){
        $salarie=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
        return $this->render('SuperAdmin/affSalarie.html.twig', [
            'salarie' => $salarie
        ]);
    }
}
