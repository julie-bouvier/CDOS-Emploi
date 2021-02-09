<?php

namespace App\Controller\AdminAssociation;
use App\Entity\ArretTravail;
use App\Entity\AutreAbsence;
use App\Entity\Avenant;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Frais;
use App\Entity\FSalarie;
use App\Entity\Heures;
use App\Entity\Prime;
use App\Entity\Association;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\AjoutInfosProType;
use App\Form\ArretTravailType;
use App\Form\AssociationType;
use App\Form\ChomageType;
use App\Form\CongesType;
use App\Form\PrimeType;
use App\Form\VerifInfosPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        $Page1 = 'Liste des salariés';
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
            'Page1' => $Page1
        ]);
    }

    /**
     * @Route("/ProfilSalarie/{idPerso}/{idmail}/{Page1}", name="ProfilSalarie")
     */
    public function ProfilSalarie($idPerso, $idmail, $Page1) {
        $InfosPerso = $this -> getDoctrine() -> getRepository(SalarieInfosPerso::class) -> find($idPerso);
        $InfosPro = $InfosPerso -> getSproid();
        $Page2 = 'Profil d\'un salarié';

        for ($i=0; $i <= count($InfosPro); $i++)
        {
            if($InfosPro[$i]!=null){
                $InfoProMailAsso = $InfosPro[$i] -> getSmailasso();
                if($InfoProMailAsso==$idmail){

                    $IdInfosPro = $InfosPro[$i] -> getSproid();
                    $InfosProAsso = $this -> getDoctrine() -> getRepository(SalarieInfosPro::class) -> find($IdInfosPro);
                    $Conges= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $ArretTravails= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $Chomages= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $AutresAbsences= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $Primes= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $Frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $Heures= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $IdInfosPro]);
                    $Avenants= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $IdInfosPro]);

                    return $this->render('Commun/ProfilSalaries.html.twig', [ // renvoie vers le twig qui affiche les infos pros et perso du salarié
                        'idPerso' => $idPerso,
                        'idInfoPro' => $IdInfosPro,
                        'infosperso' => $InfosPerso,
                        'Infospro' => $InfosProAsso,
                        'idmail'=> $idmail,
                        'conges' => $Conges,
                        'arrettravails' => $ArretTravails,
                        'chomages' => $Chomages,
                        'autresabsences' => $AutresAbsences,
                        'primes' => $Primes,
                        'frais' => $Frais,
                        'heures' => $Heures,
                        'avenants' => $Avenants,
                        'Page1'=> $Page1,
                        'Page2'=> $Page2
                    ]);
                }
            }
        }
    }

    /*######################## MODIFS INFOS SALARIES ########################*/

    /**
     * @Route("/modifInfosPerso/{idInfosPerso}/{idmail}/{Page1}/{Page2}", name="modifInfosPerso")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idInfosPerso
     * @return Response
     */
    public function modifInfosPerso(Request $request,EntityManagerInterface $entityManager, $idInfosPerso, $idmail, $Page1, $Page2){
        $infosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idInfosPerso);
        $form=$this->createForm(AjoutInfosPersoType::class, $infosperso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infosperso);
            $entityManager->flush();
            return $this->redirectToRoute('ProfilSalarie',[
                'idPerso'=>$idInfosPerso,
                'idmail'=> $idmail,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPerso.html.twig', [
                'form' => $form->createView(),
                'idSalarie'=>$idInfosPerso,
                'idmail'=> $idmail,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }


    /**
     * @Route("/modifInfosPro/{idInfosPro}/{idPerso}/{idmail}/{Page1}/{Page2}", name="modifInfosPro")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $idInfosPro
     * @return Response
     */
    public function modifInfosPro(Request $request,EntityManagerInterface $entityManager, $idInfosPro, $idmail, $idPerso, $Page1, $Page2){
        $infospro=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->find($idInfosPro);
        $form=$this->createForm(AjoutInfosProType::class, $infospro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($infospro);
            $entityManager->flush();
            return $this->redirectToRoute('ProfilSalarie',[
                'idPro'=>$idInfosPro,
                'idmail'=> $idmail,
                'idPerso'=> $idPerso,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
        else{
            return $this->render('Commun/AjoutInfosPro.html.twig', [
                'form' => $form->createView(),
                'idSalarie'=>$idInfosPro,
                'idmail'=> $idmail,
                'Page1'=>$Page1,
                'Page2'=>$Page2
            ]);
        }
    }

    /*######################## GESTION DE MON ASSO ########################*/

    /**
     * @Route("/MonAssociation/", name="MonAssociation")
     */
    public function MonAssociation() {
        $MailPersoConnecte= $this -> getUser() -> getUsername();
        $PersoConnecte = $this -> getDoctrine() -> getRepository(Connexion::class) -> find($MailPersoConnecte);
        $monAsso = $PersoConnecte -> getassociations();
        $Page1 = 'Profil d\'une association';
        return $this->render('/Commun/affMonAsso.html.twig', [
            'monAsso'=> $monAsso,
            'mailAsso'=>$MailPersoConnecte,
            'Page1'=>$Page1
        ]);
    }

    /**
     * @Route("/modifMonAsso/{mailAsso}/{Page1}", name="modifMonAsso")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $mailAsso
     * @return RedirectResponse|Response
     */
    public function modifMonAsso(Request $request,EntityManagerInterface $entityManager,$mailAsso, $Page1){
        $association=$this->getDoctrine()->getRepository(Association::class)->findOneBy(['amail'=>$mailAsso]);
        $form=$this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($association);
            $entityManager->flush();
            return $this->redirectToRoute('MonAssociation', [
                'Page1'=> $Page1,
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'assoMail'=> $mailAsso,
                'Page1' => $Page1
            ]);
        }
    }

    /*######################## GESTION DE MON ASSO ########################*/

    /**
     * @Route("/OngletDocSalaries", name="OngletDocSalaries")
     */
    public function OngletDocSalaries(){
        $MailPersoConnecte=$this-> getUser() -> getUsername();
        $PersoConnecte =$this -> getDoctrine() -> getRepository(Connexion::class) -> find($MailPersoConnecte);
        $Associations = $PersoConnecte -> getassociations();
        //boucle qui va tourner dans la collection d'associations
        //pour chaque association :
        for ($i=0; $i <= count($Associations); $i++)
        {
            //if c'est pas null
            if($Associations[$i]!=null){
                $ListeSalaries = $Associations[$i] -> getsalarieinfosperso();
            }
        }

        // renvoie vers le twig affichant la liste des salariés
        return $this->render('Commun/OngletDocsListeSalarie.html.twig', [ // renvoie vers le twig de la liste des salariés
            'associations'=> $Associations,
            'ListeSalaries' => $ListeSalaries,
        ]);
    }

    /**
     * @Route("/ListeDocsSalarie/{idPerso}", name="ListeDocsSalarie")
     */
    public function ListeDocsSalarie($idPerso){
        $infosPerso= $this -> getDoctrine() -> getRepository(SalarieInfosPerso::class) -> findBy(['spersoid'=>$idPerso]);
        $docsSalarie = $this -> getDoctrine() -> getRepository(FSalarie::class) -> findBy(['spersoid'=> $infosPerso]);


        // renvoie vers le twig affichant la liste des salariés
        return $this->render('Commun/ListeSalariesDocs.html.twig', [ // renvoie vers le twig de la liste des salariés
            'docsSalarie'=> $docsSalarie,
            'infosPerso' => $infosPerso
        ]);
    }
}



