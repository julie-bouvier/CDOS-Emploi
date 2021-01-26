<?php

namespace App\Controller\AdminAssociation;

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
use App\Form\ArretTravailType;
use App\Form\ChomageType;
use App\Form\CongesType;
use App\Form\PrimeType;
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

    /*######################## AFFICHE INFOS SALARIES ########################*/

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
        return $this->render('Commun/ListeSalaries.html.twig', [ // renvoie vers le twig de la liste des salariés
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

                    return $this->render('Commun/ProfilSalaries.html.twig', [ // renvoie vers le twig qui affiche les infos pros et perso du salarié
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
        $infosPro= $this -> getDoctrine() -> getRepository(SalarieInfosPro::class) -> find($idinfospro);
        $Conges= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $infosPro]);
        $ArretTravails= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $infosPro]);
        $Chomages= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $infosPro]);
        $AutresAbsences= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $infosPro]);
        $Primes= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $infosPro]);
        $Frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $infosPro]);
        $Heures= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $infosPro]);
        $Avenants= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $infosPro]);

        return $this->render('Commun/GestionSalaries.html.twig', [ // renvoie vers le twig qui affiche les options de gestion du salarié
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

}


