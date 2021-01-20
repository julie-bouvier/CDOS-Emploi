<?php

namespace App\Controller;

use App\Entity\SalarieInfosPerso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $toto='trugfdc';
        for ($i=0; $i <= count($Associations); $i++)
        {
            //if c'est pas null
            if($Associations[$i]!=null){
                $toto='truc';
                $ListeSalaries = $Associations[$i] -> getsalarieinfosperso();
            }
        }
        // renvoie vers le twig affichant la liste des salariés
        return $this->render('ListeSalaries.html.twig', [ // renvoie vers le twig de la liste des salariés
            'associations'=> $Associations,
            'ListeSalaries' => $ListeSalaries,
            'toto' => $toto
        ]);
    }

    /**
     * @Route("/PlusInfos/{id}", name="PlusInfos")
     */

    public function PlusInfos($id) {
        $InfosPerso = $this -> getDoctrine() -> getRepository(SalarieInfosPerso::class) -> find($id);

        return $this->render('InfosEnPlus.html.twig', [ // renvoie vers le twig qui affiche les infos pros et perso du salarié
            'infosperso'=> $InfosPerso,
        ]);
    }
}
