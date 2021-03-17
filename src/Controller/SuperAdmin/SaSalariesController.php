<?php

namespace App\Controller\SuperAdmin;

use App\Entity\ArretTravail;
use App\Entity\Association;
use App\Entity\AutreAbsence;
use App\Entity\Avenant;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Connexion;
use App\Entity\Frais;
use App\Entity\FSalarie;
use App\Entity\Heures;
use App\Entity\Prime;
use App\Entity\SalarieInfosPerso;
use App\Entity\SalarieInfosPro;
use App\Form\AjoutInfosPersoType;
use App\Form\AjoutInfosProType;
use App\Form\SalarieInfosProType;
use App\Form\VerifInfosPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
                // 'Page1'=>$Page1,
                // 'Page2'=>$Page2
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
                'idsalarie'=> $idsalarie,
                'conges' => $Conges,
                'arrettravails' => $ArretTravails,
                'chomages' => $Chomages,
                'autresabsences' => $AutresAbsences,
                'primes' => $Primes,
                'frais' => $Frais,
                'heures' => $Heures,
                'avenants' => $Avenants,
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
                'idsalarie'=> $idsalarie,
                'assoMail'=>$assoMail,
                'but'=>$but,
                'Page1'=>$Page1,
                'Page2'=>$Page2,
            ]);
        }
    }


    /*########################EXPORT INFOS SALARIES #####################*/

    /**
     * @Route("/ExportInfosSalaries/", name="ExportInfosSalaries")
     * @return Response
     */


    public function ExportInfosSalaries(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        $salariespros=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->findAll();
        $salariespersos=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->findAll();
        $arrettravails=$this->getDoctrine()->getRepository(ArretTravail::class)->findAll();
        $conges=$this->getDoctrine()->getRepository(Conges::class)->findAll();
        $chomages=$this->getDoctrine()->getRepository(Chomage::class)->findAll();
        $autreabsences=$this->getDoctrine()->getRepository(AutreAbsence::class)->findAll();
        $primes=$this->getDoctrine()->getRepository(Prime::class)->findAll();
        $frais=$this->getDoctrine()->getRepository(Frais::class)->findAll();
        $heures=$this->getDoctrine()->getRepository(Heures::class)->findAll();
        $avenants=$this->getDoctrine()->getRepository(Avenant::class)->findAll();


        setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
        $mois=(strftime(" %B %Y"));

        return $this->render('SuperAdmin/ExportInfosSalaries.html.twig', [
            'associations'=>$associations,
            'salariespros'=>$salariespros,
            'salariespersos'=>$salariespersos,
            'arrettravails' => $arrettravails,
            'conges' => $conges,
            'chomages' => $chomages,
            'autreabsences' => $autreabsences,
            'primes' => $primes,
            'frais' => $frais,
            'heures' => $heures,
            'avenants' => $avenants,
            'mois'=>$mois
        ]);

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
        $form=$this->createForm(AjoutInfosProType::class, $infospros);
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



    /*######################## Documents Salariés ########################*/

    /**
     * @Route("/OngletDocSalariesParAsso", name="OngletDocSalariesParAsso")
     */
    public function OngletDocSalariesParAsso(){

        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        $salariespros=$this->getDoctrine()->getRepository(SalarieInfosPro::class)->findAll();
        $salariespersos=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->findAll();

        return $this->render('SuperAdmin/ListeSalarieParAsso.html.twig', [
            'salariespersos' => $salariespersos, //entité salariéinfoperso
            'associations'=> $associations, //liste des associations liées à ce salarié
            'salariespros'=> $salariespros //entité salariéinfopro
        ]);
    }



    /*######################## SUPPRESSION SALARIE ########################*/

    /**
     * @Route("/validationDeleteSalarie/{idsalarie}/{assoMail}/{but}", name="validationDeleteSalarie")
     * @param $idsalarie
     * @param $assoMail
     * @param $but
     * @return Response
     */
    public function validationDeleteSalarie($idsalarie, $assoMail, $but)
    {
        if ($but=='salarie'){
            //envoyer questionnaire êtes-vous vraiment sur de supprimer ce salarié de ces associations : liste des assos
            $salarieinfosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
            $assos=$salarieinfosperso->getAmail();
            return $this->render('Commun/confirmDeleteSalarie.html.twig',[
                'associations'=>$assos,
                'salarieinfosperso'=>$salarieinfosperso,
                'but'=> $but,
            ]);
        }
        elseif ($but=='association'){
            //envoyer questionnaire ête vous vraiment sur de supprimer ce salarié de ces association : liste des assos
            $salarieinfosperso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
            $assos=$this->getDoctrine()->getRepository(Association::class)->find($assoMail);
            return $this->render('Commun/confirmDeleteSalarie.html.twig',[
                'association'=>$assos,
                'salarieinfosperso'=>$salarieinfosperso,
                'but'=>$but,
            ]);
        }
    }

    /**
     * @Route("/deleteSalarie/{idsalarie}/{assoMail}/{but}", name="deleteSalarie")
     * @param $idsalarie
     * @param $assoMail
     * @param $but
     * @return Response
     */
    public function deleteSalarie(Request $request,EntityManagerInterface $em, $idsalarie, $assoMail,$but){
        $InfoPerso=$this->getDoctrine()->getRepository(SalarieInfosPerso::class)->find($idsalarie);
        if ($but=='salarie'){

            /////// Je supprime toutes les infos pro et les tables secondaires du salarié dans ces assos ///////
            //Je récupère la liste des infos pros du salarié//
            $listeInfosPro=$InfoPerso->getSproid();

            //On parcourt la liste des infos pros liées au salarié
            for($i=0;$i <= count($listeInfosPro);++$i){
                //On vérifie si l'info pro existe
                if($listeInfosPro[$i]!=null){
                    $chomage= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($j=0;$j<count($chomage);++$j){
                        $em->remove($chomage[$j]);
                        $em->flush();
                    }
                    $conge= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($k=0;$k < count($conge);++$k){
                        if($conge[$k]!=null){
                            $em->remove($conge[$k]);
                            $em->flush();
                        }
                    }
                    $arretTravail= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($l=0;$l < count($arretTravail);++$l){
                        if($arretTravail[$l]!=null){
                            $em->remove($arretTravail[$l]);
                            $em->flush();
                        }
                    }
                    $autreAbsence= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($p=0;$p < count($autreAbsence);++$p){
                        if($autreAbsence[$p]!=null){
                            $em->remove($autreAbsence[$p]);
                            $em->flush();
                        }
                    }
                    $prime= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($r=0;$r < count($prime);++$r){
                        if($prime[$r]!=null){
                            $em->remove($prime[$r]);
                            $em->flush();
                        }
                    }
                    $frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($t=0;$t < count($frais);++$t){
                        if($frais[$t]!=null){
                            $em->remove($frais[$t]);
                            $em->flush();
                        }
                    }
                    $heure= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($v=0;$v < count($heure);++$v){
                        if($heure[$v]!=null){
                            $em->remove($heure[$v]);
                            $em->flush();
                        }
                    }
                    $avenant= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $listeInfosPro[$i]]);
                    for($y=0;$y < count($avenant);++$y){
                        if($avenant[$y]!=null){
                            $em->remove($avenant[$y]);
                            $em->flush();
                        }
                    }
                    //Si l'info pro est liée au salarié, alors on supprime le lien
                    $em->remove($listeInfosPro[$i]);
                    $em->flush();
                }
            }

            /////// Je supprime la table des fichiers F_salariePerso ///////

            //On récupère la liste des associations liées au salarié
            $listeDocSalarie= $this -> getDoctrine() -> getRepository(FSalarie::class) -> findBy(['spersoid'=> $InfoPerso]);
            //On parcourt la liste des associations liées au salarié
            for($i=0;$i < count($listeDocSalarie);++$i){
                //On vérifie si 'asso existe
                if($listeDocSalarie[$i]!=null){
                    //Si le groupe est lié à l'asso, alors on supprime le lien
                    $em->remove($listeDocSalarie[$i]);
                    $em->flush();
                }
            }

            //On supprime le lien entre les infos persos et les associations
            $listeAsso= $InfoPerso->getAmail();
            for($i=0;$i < count($listeAsso);++$i){
                $ListeSalaries = $listeAsso[$i]->getsalarieinfosperso();
                //On parcours la liste des salariés
                for($i=0;$i < count($ListeSalaries);++$i){
                    //On vérifie si 'asso existe
                    if($ListeSalaries[$i]==$InfoPerso){
                        //Si les infos perso du salarie de la liste correspondent aux infos perso du salarié à supprimer
                        $em->remove($ListeSalaries[$i]);
                        $em->flush();
                    }
                }
            }


            //On supprime les infos persos ce qui va automatiquement supprimer le lien avec les associations

            $em->remove($InfoPerso);
            $em->flush();

            //je revoi vers la page AffAllSalarie,de l'onglet salarie
            return $this->redirectToRoute('affAllSalaries', [
                'but'=>$but
            ]);
        }

        elseif ($but=='association'){
            $ListeInfoPro=$InfoPerso->getSproid();

            for($i=0;$i <= count($ListeInfoPro);++$i){
                $amail=$ListeInfoPro[$i]->getSmailasso();
                if ($amail==$assoMail){
                    $chomage= $this -> getDoctrine() -> getRepository(Chomage::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($j=0;$j<count($chomage);++$j){
                        $em->remove($chomage[$j]);
                        $em->flush();
                    }
                    $conge= $this -> getDoctrine() -> getRepository(Conges::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($k=0;$k < count($conge);++$k){
                        if($conge[$k]!=null){
                            $em->remove($conge[$k]);
                            $em->flush();
                        }
                    }
                    $arretTravail= $this -> getDoctrine() -> getRepository(ArretTravail::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($l=0;$l < count($arretTravail);++$l){
                        if($arretTravail[$l]!=null){
                            $em->remove($arretTravail[$l]);
                            $em->flush();
                        }
                    }
                    $autreAbsence= $this -> getDoctrine() -> getRepository(AutreAbsence::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($p=0;$p < count($autreAbsence);++$p){
                        if($autreAbsence[$p]!=null){
                            $em->remove($autreAbsence[$p]);
                            $em->flush();
                        }
                    }
                    $prime= $this -> getDoctrine() -> getRepository(Prime::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($r=0;$r < count($prime);++$r){
                        if($prime[$r]!=null){
                            $em->remove($prime[$r]);
                            $em->flush();
                        }
                    }
                    $frais= $this -> getDoctrine() -> getRepository(Frais::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($t=0;$t < count($frais);++$t){
                        if($frais[$t]!=null){
                            $em->remove($frais[$t]);
                            $em->flush();
                        }
                    }
                    $heure= $this -> getDoctrine() -> getRepository(Heures::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($v=0;$v < count($heure);++$v){
                        if($heure[$v]!=null){
                            $em->remove($heure[$v]);
                            $em->flush();
                        }
                    }
                    $avenant= $this -> getDoctrine() -> getRepository(Avenant::class) -> findBy(['sproid'=> $ListeInfoPro[$i]]);
                    for($y=0;$y < count($avenant);++$y){
                        if($avenant[$y]!=null){
                            $em->remove($avenant[$y]);
                            $em->flush();
                        }
                    }
                    //Si l'info pro est liée au salarié, alors on supprime le lien
                    $em->remove($ListeInfoPro[$i]);
                    $em->flush();

                    //On supprime le lien entre les infos persos et l'association
                    $Asso= $this -> getDoctrine() -> getRepository(Association::class) -> findOneBy(['amail'=>$assoMail]);
                    $ListeSalaries = $Asso-> getsalarieinfosperso();
                    //On parcours la liste des salariés
                    for ($k = 0; $k < count($ListeSalaries); ++$k) {
                        //Si les infos perso du salarie de la liste correspondent aux infos perso du salarié à supprimer
                        if ($ListeSalaries[$k] == $InfoPerso) {
                            //Alors on supprime le lien entre l'asso et l'info perso
                            $Asso-> removeSalarieinfosperso($ListeSalaries[$k]);
                            $em->flush();

                            //je redirige vers la page AffAllSalarie de l'onglet association
                            $Page1='Liste des associations';
                            return $this->redirectToRoute('affSalaries',[
                                'assomail'=>$assoMail,
                                'Page1' => $Page1,
                            ]);

                        }
                    }

                }
            }

        }
    }






    /**
     * @Route("/test/", name="test")
     */
    public function test(){
        return $this->render('home/test.html.twig');
    }
}