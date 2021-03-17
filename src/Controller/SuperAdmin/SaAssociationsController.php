<?php

namespace App\Controller\SuperAdmin;

use App\Entity\ArretTravail;
use App\Entity\Association;
use App\Entity\AutreAbsence;
use App\Entity\Avenant;
use App\Entity\Chomage;
use App\Entity\Conges;
use App\Entity\Connexion;
use App\Entity\FAssociation;
use App\Entity\Frais;
use App\Entity\FSalarie;
use App\Entity\Heures;
use App\Entity\Prime;
use App\Entity\SalarieInfosPerso;
use App\Form\AssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SaAssociationsController extends AbstractController
{
    /**
     * @Route("/affAssociation/{but}", name="affAssociation")
     * @param $but
     * @return Response
     */
    public function affAssociation($but){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();

        //on crée la page 1
        $Page1='Liste des associations';
        //si mon but est de gérer les association alors on renvoi vers la page affAllAsso
        if ($but=="association"){
            return $this->render('SuperAdmin/affAllAssociations.html.twig', [
                'associations' => $associations,
                'but'=> $but,
                'Page1' => $Page1
            ]);
        }
        //si mon but est de gérer les salariés alors on renvoi vers la page affassosalaries
        elseif ($but=="salaries"){
            return $this->render('SuperAdmin/affAllAssociationsSalaries.html.twig', [
                'associations' => $associations,
            ]);
        }
    }

    /**
     * @Route("/EnregistrerAssociation/{comail}", name="EnregistrerAssociation")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $comail
     * @return Response
     */
    public function EnregistrerAssociation(Request $request,EntityManagerInterface $entityManager, $comail ){
        //je veux ajouter des informations dans ma table association
        //liée cette table à la table connexion précédente

        //je crée un objet association
        $asso=new Association();
        //je mets automatiquement le champs aMail=coMail
        $asso->setAmail($comail);
        //je donne un formulaire avec les champs de la table association
        $form=$this->createForm(AssociationType::class, $asso);
        $form->handleRequest($request);

        //quand je clique sur valider le form, meme si les champs ne sont pas remplis, je persist and flush avec la bdd
        if ($form->isSubmitted() && $form->isValid()){

            //on lie l'association à la connexion en passant par le addAssociation dans connexion
            $connexion=$this->getDoctrine()->getRepository(Connexion::class)->find($comail);
            $connexion->addAssociation($asso);
            //on lie la connexion à l'association en passant par le addConnexion dans association
            $asso->addConnexion($connexion);

            //j'enregistre la nouvelle asso dans la bdd
            $entityManager->persist($asso);
            $entityManager->flush();
            //je redirecte vers page ou route
            return $this->redirectToRoute('affAssociation',[
                'but'=>'association'
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'comail'=> $comail
            ]);
        }
    }

    /**
     * @Route("/voirAssociation/{but}/{assomail}/{Page1}", name="voirAssociation")
     * @param $assomail
     * @param $Page1
     * @return Response
     */
    public function voirAssociation($but, $assomail, $Page1){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assomail);
        $Page2='Profil de l\'association';
        return $this->render('SuperAdmin/affAssociation.html.twig', [
            'association' => $association,
            'but'=> $but,
            'Page1'=>$Page1,
            'Page2'=>$Page2
        ]);
    }

    /**
     * @Route("/modifAssociation{assoMail}/{Page1}", name="modifAssociation")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $assoMail
     * @return RedirectResponse|Response
     */
    public function modifAssociation(Request $request,EntityManagerInterface $entityManager,$assoMail,$Page1){
        $association=$this->getDoctrine()->getRepository(Association::class)->find($assoMail);
        $form=$this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($association);
            $entityManager->flush();
            return $this->redirectToRoute('affAssociation',[
                'but'=>'association',
                'Page1'=>$Page1
            ]);
        }
        else{
            return $this->render('SuperAdmin/AjoutAssociation.html.twig', [
                'form' => $form->createView(),
                'assoMail'=> $assoMail,
                'Page1'=>$Page1
            ]);
        }
    }

    /**
     * @Route("/Choixasso/{role}/{Page1}", name="Choixasso")
     * @param $role
     * @return Response
     */
    public function Choixasso($role, $Page1){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();
        $Page2='Ajout : Choix d\'une association';
        $but='salarie';
        return $this->render('SuperAdmin/choixAssociations.html.twig', [
            'associations' => $associations,
            'but'=> $but,
            'role'=>$role,
            'Page1'=>$Page1,
            'Page2'=>$Page2
        ]);
    }
    /*########################EXPORT INFOS SALARIES #####################*/

    /**
     * @Route("/ExportInfosAsso", name="ExportInfosAsso")
     * @return Response
     */
    public function ExportInfosAsso(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();


        return $this->render('SuperAdmin/ExportInfosAssos.html.twig', [
            'associations'=>$associations,

        ]);

    }

    /*######################## Documents Salariés ########################*/

    /**
     * @Route("/OngletDocListeAssociations", name="OngletDocListeAssociations")
     */
    public function OngletDocListeAssociations(){
        $associations=$this->getDoctrine()->getRepository(Association::class)->findAll();

            return $this->render('Commun/OngletDocListeAssociations.html.twig', [
                'associations' => $associations,
            ]);
    }

    /**
     * @Route("/ListeDocsAssociation/{amail}", name="ListeDocsAssociation")
     */
    public function ListeDocsAssociation($amail){
        $Asso=$this -> getDoctrine() -> getRepository(Association::class) -> find($amail);
        $docsAsso=$this -> getDoctrine() -> getRepository(FAssociation::class) -> findBy(['amail'=> $Asso]);

        return $this->render('Commun/ListeDocsAssociation.html.twig', [ // renvoie vers le twig de la liste des documents de l'asso
            'docsAsso'=> $docsAsso
        ]);
    }

    /**
     * @Route("/deleteAsso/{but}/{assoMail}", name="deleteAsso")
     * @param $assoMail
     * @param $but
     * @return RedirectResponse
     */
    public function deleteAsso(Request $request,EntityManagerInterface $em, $assoMail,$but)
    {
        $Asso = $this->getDoctrine()->getRepository(Association::class)->find($assoMail);

            /////// Je récupère la liste des salariés
            $listeSalaries = $Asso->getsalarieinfosperso();

            /////// On tourne dans la liste des infos perso des salariés
            for ($i = 0; $i <= count($listeSalaries); ++$i) {

                /////// Je supprime toutes les infos pro et les tables secondaires du salarié dans ces assos ///////

                $listeInfosPro = $listeSalaries[$i]->getSproid();

                //On parcourt la liste des infos pros liées au salarié
                for ($i = 0; $i < count($listeInfosPro); ++$i) {
                    //On vérifie si l'info pro existe
                    if ($listeInfosPro[$i] != null) {
                        $chomage = $this->getDoctrine()->getRepository(Chomage::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($j = 0; $j < count($chomage); ++$j) {
                            $em->remove($chomage[$j]);
                            $em->flush();
                        }
                        $conge = $this->getDoctrine()->getRepository(Conges::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($k = 0; $k < count($conge); ++$k) {
                            if ($conge[$k] != null) {
                                $em->remove($conge[$k]);
                                $em->flush();
                            }
                        }
                        $arretTravail = $this->getDoctrine()->getRepository(ArretTravail::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($l = 0; $l < count($arretTravail); ++$l) {
                            if ($arretTravail[$l] != null) {
                                $em->remove($arretTravail[$l]);
                                $em->flush();
                            }
                        }
                        $autreAbsence = $this->getDoctrine()->getRepository(AutreAbsence::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($p = 0; $p < count($autreAbsence); ++$p) {
                            if ($autreAbsence[$p] != null) {
                                $em->remove($autreAbsence[$p]);
                                $em->flush();
                            }
                        }
                        $prime = $this->getDoctrine()->getRepository(Prime::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($r = 0; $r < count($prime); ++$r) {
                            if ($prime[$r] != null) {
                                $em->remove($prime[$r]);
                                $em->flush();
                            }
                        }
                        $frais = $this->getDoctrine()->getRepository(Frais::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($t = 0; $t < count($frais); ++$t) {
                            if ($frais[$t] != null) {
                                $em->remove($frais[$t]);
                                $em->flush();
                            }
                        }
                        $heure = $this->getDoctrine()->getRepository(Heures::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($v = 0; $v < count($heure); ++$v) {
                            if ($heure[$v] != null) {
                                $em->remove($heure[$v]);
                                $em->flush();
                            }
                        }
                        $avenant = $this->getDoctrine()->getRepository(Avenant::class)->findBy(['sproid' => $listeInfosPro[$i]]);
                        for ($y = 0; $y < count($avenant); ++$y) {
                            if ($avenant[$y] != null) {
                                $em->remove($avenant[$y]);
                                $em->flush();
                            }
                        }
                        //On supprime l'info pro
                        $em->remove($listeInfosPro[$i]);
                        $em->flush();
                    }
                }
                // On supprime la connexion lié à l'asso
                $CoAsso = $this->getDoctrine()->getRepository(Connexion::class)->findBy(['comail' => $assoMail]);
                for ($y = 0; $y < count($CoAsso); ++$y) {
                    $em->remove($CoAsso[$y]);
                    $em->flush();
                }


                // On supprime l'associations
                $em->remove($Asso);
                $em->flush();
            }

            // Je revoi vers la page AffAllSalarie,de l'onglet salarie
            return $this->redirectToRoute('affAssociation', [
                'but' => $but
            ]);
        }
}
