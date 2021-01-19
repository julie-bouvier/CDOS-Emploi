<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Association
 *
 * @ORM\Table(name="association")
 * @ORM\Entity
 */
class Association
{
    /**
     * @var string
     *
     * @ORM\Column(name="aMail", type="string", length=25, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $amail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aNom", type="string", length=25, nullable=true)
     */
    private $anom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aAdresse", type="text", length=65535, nullable=true)
     */
    private $aadresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aTel", type="string", length=25, nullable=true)
     */
    private $atel;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="aDateCreation", type="date", nullable=true)
     */
    private $adatecreation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="aDateEmbauche", type="date", nullable=true)
     */
    private $adateembauche;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aFederation", type="string", length=50, nullable=true)
     */
    private $afederation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aSIRET", type="integer", nullable=true)
     */
    private $asiret;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aAPE", type="string", length=50, nullable=true)
     */
    private $aape;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aURSSAF", type="string", length=50, nullable=true)
     */
    private $aurssaf;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aCodeRisque", type="integer", nullable=true)
     */
    private $acoderisque;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aTauxAccidentTravail", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $atauxaccidenttravail;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aPEIdentifiant", type="integer", nullable=true)
     */
    private $apeidentifiant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aPECodePerso", type="integer", nullable=true)
     */
    private $apecodeperso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCaisseRetraite", type="string", length=50, nullable=true)
     */
    private $acaisseretraite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCaisseRetraiteNumAdh", type="string", length=100, nullable=true)
     */
    private $acaisseretraitenumadh;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCaissePrevoyance", type="string", length=50, nullable=true)
     */
    private $acaisseprevoyance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPP", type="string", length=50, nullable=true)
     */
    private $app;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aP0", type="string", length=50, nullable=true)
     */
    private $ap0;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aComplementaire", type="string", length=50, nullable=true)
     */
    private $acomplementaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aComplementaireAdh", type="string", length=50, nullable=true)
     */
    private $acomplementaireadh;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aICOM", type="integer", nullable=true)
     */
    private $aicom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aASSTV", type="string", length=50, nullable=true)
     */
    private $aasstv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPresNom", type="string", length=25, nullable=true)
     */
    private $apresnom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPresAdresse", type="text", length=65535, nullable=true)
     */
    private $apresadresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPresPortable", type="string", length=25, nullable=true)
     */
    private $apresportable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPresTel", type="string", length=25, nullable=true)
     */
    private $aprestel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aPresMail", type="string", length=25, nullable=true)
     */
    private $apresmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aGestionNom", type="string", length=25, nullable=true)
     */
    private $agestionnom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCorrespondAdresse", type="text", length=65535, nullable=true)
     */
    private $acorrespondadresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCorrespondPortable", type="string", length=25, nullable=true)
     */
    private $acorrespondportable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCorrespondTel", type="string", length=25, nullable=true)
     */
    private $acorrespondtel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aCorrespondMail", type="string", length=25, nullable=true)
     */
    private $acorrespondmail;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aCourriersInternet", type="integer", nullable=true)
     */
    private $acourriersinternet;

    /**
     * @var int|null
     *
     * @ORM\Column(name="aEnvoiCourrier", type="integer", nullable=true)
     */
    private $aenvoicourrier;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aModePaiement", type="string", length=50, nullable=true)
     */
    private $amodepaiement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aRIB", type="string", length=30, nullable=true)
     */
    private $arib;

    /**
     * @var string|null
     *
     * @ORM\Column(name="aInfoComplementaire", type="text", length=65535, nullable=true)
     */
    private $ainfocomplementaire;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="aDateAdhesion", type="date", nullable=true)
     */
    private $adateadhesion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="SalarieInfosPerso", inversedBy="amail")
     * @ORM\JoinTable(name="est_compose_de",
     *   joinColumns={
     *     @ORM\JoinColumn(name="aMail", referencedColumnName="aMail")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="sPersoId", referencedColumnName="sPersoId")
     *   }
     * )
     */
    private $spersoid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Connexion", inversedBy="amail")
     * @ORM\JoinTable(name="gere",
     *   joinColumns={
     *     @ORM\JoinColumn(name="aMail", referencedColumnName="aMail")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="coMail", referencedColumnName="coMail")
     *   }
     * )
     */
    private $comail;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->spersoid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comail = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
