<?php

namespace App\Controller;

use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
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

        return $this->render('admin/ProfilSalaries.html.twig', [ // renvoie vers le twig qui affiche les infos pros et perso du salarié
            'infosperso' => $InfosPerso,

        ]);

    }

    /**
     * @Route("/VerifInfosPerso/{mailasso}", name="VerifInfosPerso")
     */

    public function VerifInfosPerso($mailasso, Request $request) {

        $NewInfosPerso = new SalarieInfosPerso();
        $form = $this->createForm(VerifInfosPersoType::class, $NewInfosPerso);
        $form->handleRequest($request);

        //Creation du tableau des Informations a vérifier qui est vide
        $ListeInfoAVerif= [];

        if($form->isSubmitted() && $form->isValid()) {
        //On récupère le numéro de sécu du salarié tapé dans le formulaire
            $numsecu = $NewInfosPerso ->getSnumsecu();
            if ($numsecu!=null)
                $ListeInfoAVerif= $this -> getDoctrine() -> getRepository(SalarieInfosPerso::class) -> findBy(['snumsecu'=>$numsecu]);
        }

        return $this->render('admin/AjoutInfosPerso.html.twig', [
            'form' => $form->createView(), 'ListeInfoAVerif' => $ListeInfoAVerif
        ]);


    }


}
