<?php

namespace App\Controller\SuperAdmin;

use App\Entity\ArretTravail;
use App\Entity\Association;
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
     * @Route("/affSalaries/{assomail}/{Page1}", name="affSalaries")
     */
    public function affSalaries($assomail,$Page1){
        //je récupère l'association sur laquelle j'ai cliqué
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        //je récupère la liste des salariés de cette asso
        $listsalaries=$association->getsalarieinfosperso();
        $Page2='Liste des Salariés';

        if (empty($listsalaries)){
            $message='Il n\'y a pas de salariés enregistrés dans cette association';
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'message' => $message,
                'assoMail' => $assomail,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
        else{
            return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
                'listsalaries' => $listsalaries,
                'assoMail' => $assomail,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /**
     * @Route("/affAllSalaries/{but}", name="affAllSalaries")
     */
    public function affAllSalaries($but){
        //je récupère la liste de tous les salaries
        $listsalaries=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->findAll();
        $Page1='Liste des salariés';
        $Page2='Profil d\'un salarié';

        return $this->render('SuperAdmin/affAllSalariesAsso.html.twig', [
            'listsalaries' => $listsalaries,
            'but'=> $but,
            'Page1' => $Page1,
            'Page2' => $Page2
        ]);
    }

    /**
     * @Route("/voirSalarie/{idsalarie}/{assoMail}/{but}/{Page1}/{Page2}", name="voirSalarie")
     * @param $idsalarie
     * @param $assoMail
     * @param $but
     * @return Response
     */
    public function voirSalarie($idsalarie, $assoMail, $but, $Page1, $Page2){
        //récupérer l'objet salarié avec notre id
        $salarie=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
        $Page3='Profil d\'un salarié';
        //if but = association alors je trouve l'aaso avec  assomail et les infos pro de cette asso
        //on veut afficher les informations du salariés QUE de l'asso cliquée (assoMail)
        if ($but=='association'){
            $associations=$this->getDoctrine()->getRepository(Association::class)->findBy(['amail'=>$assoMail]); //attention une seule association

            // on a une liste d'entité salarie infos pro = $infospros
            $infospros=$salarie->getSproid();

            // TOURNER dans cette liste
            if ($infospros!=null){
                for ($i=0; $i<count($infospros); $i++){
                    if ($infospros[$i]!=null){
                        $toto='$infopro[$i] est aps null';
                        $cemaildecetteasso=$infospros[$i]->getSmailasso();
                        // pour chaque entité de cette liste, on vérifie SI son salarieinfospro.smailasso = $assoMail
                        if ($cemaildecetteasso==$assoMail){
                            //si salarieinfospro.$smailasso = $assoMail ALORS on récupère celui là, c celui qu'on veut => $wantinfospro
                            $wantinfospro=$infospros[$i];
                            break;
                        }
                    }

                }
            }

            //toutes les infos des tables secondaires de ce nouvel infopro
            $Conges= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $wantinfospro]);
            $ArretTravails= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $wantinfospro]);
            $Chomages= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $wantinfospro]);
            $AutresAbsences= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $wantinfospro]);
            $Primes= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $wantinfospro]);
            $Frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $wantinfospro]);
            $Heures= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $wantinfospro]);
            $Avenants= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $wantinfospro]);

            return $this->render('SuperAdmin/affSalarie.html.twig', [
                'salarie' => $salarie, //entité salariéinfoperso
                'associations'=>$associations, //liste des associations liées à ce salarié
                'infospros'=>$infospros, //liste des salariésinfospro liés à ce salarié
                'conges' => $Conges,
                'arrettravails' => $ArretTravails,
                'chomages' => $Chomages,
                'autresabsences' => $AutresAbsences,
                'primes' => $Primes,
                'frais' => $Frais,
                'heures' => $Heures,
                'avenants' => $Avenants,
                'toto'=>$toto,
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2,
                'Page3'=>$Page3
            ]);
        }
        elseif ($but=='salarie') {
            $Page2='Profil d\'un salarié';
            //if but = salarie alors je cherhe toutes les assos et les infos pro du salarie
            //trouver la liste des associations liées à ce salarié
            $associations = $salarie->getAmail();
            //trouvé les salariés infos pro liés à ce salarié
            $infospros = $salarie->getSproid();

            return $this->render('SuperAdmin/affSalarie.html.twig', [
                'salarie' => $salarie, //entité salariéinfoperso
                'associations'=>$associations, //liste des associations liées à ce salarié
                'infospros'=>$infospros, //liste des salariés infos pro liés à ce salarié
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2,
            ]);
        }
    }

    /*######################## SALARIE INFOS PRO ########################*/

    /**
     * @Route("/modifSalariesPro/{idInfoProSalarie}/{idSalarie}/{assoMail}/{but}/{Page1}/{Page2}", name="modifSalariesPro")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idInfoProSalarie
     * @param $idSalarie
     * @return Response
     */
    public function modifSalariesPro(Request $request,EntityManagerInterface $entityManager,$idInfoProSalarie, $idSalarie, $assoMail, $but, $Page1, $Page2){
        $infospros=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($idInfoProSalarie);
        $form=$this->createForm(SalarieInfosProType::class, $infospros);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infospros);
            $entityManager->flush();
            return $this->redirectToRoute('voirSalarie',[
                'idsalarie'=>$idSalarie,
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPro.html.twig', [
                'form' => $form->createView(),
                'idInfoProSalarie'=> $idInfoProSalarie,
                'idSalarie'=>$idSalarie,
                'Page1'=>$Page1,
                'Page2'=>$Page2,
            ]);
        }
    }

    /*######################## SALARIE INFOS PERSO ########################*/

    /**
     * @Route("/modifSalariesPerso/{idSalarie}/{assoMail}/{but}/{Page1}/{Page2}", name="modifSalariesPerso")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idSalarie
     * @return Response
     */
    public function modifSalariesPerso(Request $request,EntityManagerInterface $entityManager, $idSalarie, $assoMail, $but, $Page1, $Page2){
        $infosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idSalarie);
        $form=$this->createForm(AjoutInfosPersoType::class, $infosperso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infosperso);
            $entityManager->flush();
            return $this->redirectToRoute('voirSalarie',[
                'idsalarie'=>$idSalarie,
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'idSalarie'=>$idSalarie,
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }
}