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
     *     @ORM\JoinColumn(name="spersoid", referencedColumnName="spersoid")
     *   }
     * )
     */
    private $salarieinfosperso;

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
        $this->salarieinfosperso = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comail = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * GETTER & SETTER
     */


    /**
     * @return string
     */
    public function getAmail(): string
    {
        return $this->amail;
    }

    /**
     * @param string $amail
     */
    public function setAmail(string $amail): void
    {
        $this->amail = $amail;
    }

    /**
     * @return string|null
     */
    public function getAnom(): ?string
    {
        return $this->anom;
    }

    /**
     * @param string|null $anom
     */
    public function setAnom(?string $anom): void
    {
        $this->anom = $anom;
    }

    /**
     * @return string|null
     */
    public function getAadresse(): ?string
    {
        return $this->aadresse;
    }

    /**
     * @param string|null $aadresse
     */
    public function setAadresse(?string $aadresse): void
    {
        $this->aadresse = $aadresse;
    }

    /**
     * @return string|null
     */
    public function getAtel(): ?string
    {
        return $this->atel;
    }

    /**
     * @param string|null $atel
     */
    public function setAtel(?string $atel): void
    {
        $this->atel = $atel;
    }

    /**
     * @return \DateTime|null
     */
    public function getAdatecreation(): ?\DateTime
    {
        return $this->adatecreation;
    }

    /**
     * @param \DateTime|null $adatecreation
     */
    public function setAdatecreation(?\DateTime $adatecreation): void
    {
        $this->adatecreation = $adatecreation;
    }

    /**
     * @return \DateTime|null
     */
    public function getAdateembauche(): ?\DateTime
    {
        return $this->adateembauche;
    }

    /**
     * @param \DateTime|null $adateembauche
     */
    public function setAdateembauche(?\DateTime $adateembauche): void
    {
        $this->adateembauche = $adateembauche;
    }

    /**
     * @return string|null
     */
    public function getAfederation(): ?string
    {
        return $this->afederation;
    }

    /**
     * @param string|null $afederation
     */
    public function setAfederation(?string $afederation): void
    {
        $this->afederation = $afederation;
    }

    /**
     * @return int|null
     */
    public function getAsiret(): ?int
    {
        return $this->asiret;
    }

    /**
     * @param int|null $asiret
     */
    public function setAsiret(?int $asiret): void
    {
        $this->asiret = $asiret;
    }

    /**
     * @return string|null
     */
    public function getAape(): ?string
    {
        return $this->aape;
    }

    /**
     * @param string|null $aape
     */
    public function setAape(?string $aape): void
    {
        $this->aape = $aape;
    }

    /**
     * @return string|null
     */
    public function getAurssaf(): ?string
    {
        return $this->aurssaf;
    }

    /**
     * @param string|null $aurssaf
     */
    public function setAurssaf(?string $aurssaf): void
    {
        $this->aurssaf = $aurssaf;
    }

    /**
     * @return int|null
     */
    public function getAcoderisque(): ?int
    {
        return $this->acoderisque;
    }

    /**
     * @param int|null $acoderisque
     */
    public function setAcoderisque(?int $acoderisque): void
    {
        $this->acoderisque = $acoderisque;
    }

    /**
     * @return string|null
     */
    public function getAtauxaccidenttravail(): ?string
    {
        return $this->atauxaccidenttravail;
    }

    /**
     * @param string|null $atauxaccidenttravail
     */
    public function setAtauxaccidenttravail(?string $atauxaccidenttravail): void
    {
        $this->atauxaccidenttravail = $atauxaccidenttravail;
    }

    /**
     * @return int|null
     */
    public function getApeidentifiant(): ?int
    {
        return $this->apeidentifiant;
    }

    /**
     * @param int|null $apeidentifiant
     */
    public function setApeidentifiant(?int $apeidentifiant): void
    {
        $this->apeidentifiant = $apeidentifiant;
    }

    /**
     * @return int|null
     */
    public function getApecodeperso(): ?int
    {
        return $this->apecodeperso;
    }

    /**
     * @param int|null $apecodeperso
     */
    public function setApecodeperso(?int $apecodeperso): void
    {
        $this->apecodeperso = $apecodeperso;
    }

    /**
     * @return string|null
     */
    public function getAcaisseretraite(): ?string
    {
        return $this->acaisseretraite;
    }

    /**
     * @param string|null $acaisseretraite
     */
    public function setAcaisseretraite(?string $acaisseretraite): void
    {
        $this->acaisseretraite = $acaisseretraite;
    }

    /**
     * @return string|null
     */
    public function getAcaisseretraitenumadh(): ?string
    {
        return $this->acaisseretraitenumadh;
    }

    /**
     * @param string|null $acaisseretraitenumadh
     */
    public function setAcaisseretraitenumadh(?string $acaisseretraitenumadh): void
    {
        $this->acaisseretraitenumadh = $acaisseretraitenumadh;
    }

    /**
     * @return string|null
     */
    public function getAcaisseprevoyance(): ?string
    {
        return $this->acaisseprevoyance;
    }

    /**
     * @param string|null $acaisseprevoyance
     */
    public function setAcaisseprevoyance(?string $acaisseprevoyance): void
    {
        $this->acaisseprevoyance = $acaisseprevoyance;
    }

    /**
     * @return string|null
     */
    public function getApp(): ?string
    {
        return $this->app;
    }

    /**
     * @param string|null $app
     */
    public function setApp(?string $app): void
    {
        $this->app = $app;
    }

    /**
     * @return string|null
     */
    public function getAp0(): ?string
    {
        return $this->ap0;
    }

    /**
     * @param string|null $ap0
     */
    public function setAp0(?string $ap0): void
    {
        $this->ap0 = $ap0;
    }

    /**
     * @return string|null
     */
    public function getAcomplementaire(): ?string
    {
        return $this->acomplementaire;
    }

    /**
     * @param string|null $acomplementaire
     */
    public function setAcomplementaire(?string $acomplementaire): void
    {
        $this->acomplementaire = $acomplementaire;
    }

    /**
     * @return string|null
     */
    public function getAcomplementaireadh(): ?string
    {
        return $this->acomplementaireadh;
    }

    /**
     * @param string|null $acomplementaireadh
     */
    public function setAcomplementaireadh(?string $acomplementaireadh): void
    {
        $this->acomplementaireadh = $acomplementaireadh;
    }

    /**
     * @return int|null
     */
    public function getAicom(): ?int
    {
        return $this->aicom;
    }

    /**
     * @param int|null $aicom
     */
    public function setAicom(?int $aicom): void
    {
        $this->aicom = $aicom;
    }

    /**
     * @return string|null
     */
    public function getAasstv(): ?string
    {
        return $this->aasstv;
    }

    /**
     * @param string|null $aasstv
     */
    public function setAasstv(?string $aasstv): void
    {
        $this->aasstv = $aasstv;
    }

    /**
     * @return string|null
     */
    public function getApresnom(): ?string
    {
        return $this->apresnom;
    }

    /**
     * @param string|null $apresnom
     */
    public function setApresnom(?string $apresnom): void
    {
        $this->apresnom = $apresnom;
    }

    /**
     * @return string|null
     */
    public function getApresadresse(): ?string
    {
        return $this->apresadresse;
    }

    /**
     * @param string|null $apresadresse
     */
    public function setApresadresse(?string $apresadresse): void
    {
        $this->apresadresse = $apresadresse;
    }

    /**
     * @return string|null
     */
    public function getApresportable(): ?string
    {
        return $this->apresportable;
    }

    /**
     * @param string|null $apresportable
     */
    public function setApresportable(?string $apresportable): void
    {
        $this->apresportable = $apresportable;
    }

    /**
     * @return string|null
     */
    public function getAprestel(): ?string
    {
        return $this->aprestel;
    }

    /**
     * @param string|null $aprestel
     */
    public function setAprestel(?string $aprestel): void
    {
        $this->aprestel = $aprestel;
    }

    /**
     * @return string|null
     */
    public function getApresmail(): ?string
    {
        return $this->apresmail;
    }

    /**
     * @param string|null $apresmail
     */
    public function setApresmail(?string $apresmail): void
    {
        $this->apresmail = $apresmail;
    }

    /**
     * @return string|null
     */
    public function getAgestionnom(): ?string
    {
        return $this->agestionnom;
    }

    /**
     * @param string|null $agestionnom
     */
    public function setAgestionnom(?string $agestionnom): void
    {
        $this->agestionnom = $agestionnom;
    }

    /**
     * @return string|null
     */
    public function getAcorrespondadresse(): ?string
    {
        return $this->acorrespondadresse;
    }

    /**
     * @param string|null $acorrespondadresse
     */
    public function setAcorrespondadresse(?string $acorrespondadresse): void
    {
        $this->acorrespondadresse = $acorrespondadresse;
    }

    /**
     * @return string|null
     */
    public function getAcorrespondportable(): ?string
    {
        return $this->acorrespondportable;
    }

    /**
     * @param string|null $acorrespondportable
     */
    public function setAcorrespondportable(?string $acorrespondportable): void
    {
        $this->acorrespondportable = $acorrespondportable;
    }

    /**
     * @return string|null
     */
    public function getAcorrespondtel(): ?string
    {
        return $this->acorrespondtel;
    }

    /**
     * @param string|null $acorrespondtel
     */
    public function setAcorrespondtel(?string $acorrespondtel): void
    {
        $this->acorrespondtel = $acorrespondtel;
    }

    /**
     * @return string|null
     */
    public function getAcorrespondmail(): ?string
    {
        return $this->acorrespondmail;
    }

    /**
     * @param string|null $acorrespondmail
     */
    public function setAcorrespondmail(?string $acorrespondmail): void
    {
        $this->acorrespondmail = $acorrespondmail;
    }

    /**
     * @return int|null
     */
    public function getAcourriersinternet(): ?int
    {
        return $this->acourriersinternet;
    }

    /**
     * @param int|null $acourriersinternet
     */
    public function setAcourriersinternet(?int $acourriersinternet): void
    {
        $this->acourriersinternet = $acourriersinternet;
    }

    /**
     * @return int|null
     */
    public function getAenvoicourrier(): ?int
    {
        return $this->aenvoicourrier;
    }

    /**
     * @param int|null $aenvoicourrier
     */
    public function setAenvoicourrier(?int $aenvoicourrier): void
    {
        $this->aenvoicourrier = $aenvoicourrier;
    }

    /**
     * @return string|null
     */
    public function getAmodepaiement(): ?string
    {
        return $this->amodepaiement;
    }

    /**
     * @param string|null $amodepaiement
     */
    public function setAmodepaiement(?string $amodepaiement): void
    {
        $this->amodepaiement = $amodepaiement;
    }

    /**
     * @return string|null
     */
    public function getArib(): ?string
    {
        return $this->arib;
    }

    /**
     * @param string|null $arib
     */
    public function setArib(?string $arib): void
    {
        $this->arib = $arib;
    }

    /**
     * @return string|null
     */
    public function getAinfocomplementaire(): ?string
    {
        return $this->ainfocomplementaire;
    }

    /**
     * @param string|null $ainfocomplementaire
     */
    public function setAinfocomplementaire(?string $ainfocomplementaire): void
    {
        $this->ainfocomplementaire = $ainfocomplementaire;
    }

    /**
     * @return \DateTime|null
     */
    public function getAdateadhesion(): ?\DateTime
    {
        return $this->adateadhesion;
    }

    /**
     * @param \DateTime|null $adateadhesion
     */
    public function setAdateadhesion(?\DateTime $adateadhesion): void
    {
        $this->adateadhesion = $adateadhesion;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getsalarieinfosperso(): \Doctrine\Common\Collections\Collection
    {
        return $this->salarieinfosperso;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $salarieinfosperso
     */
    public function setsalarieinfosperso(\Doctrine\Common\Collections\Collection $salarieinfosperso): void
    {
        $this->salarieinfosperso = $salarieinfosperso;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComail(): \Doctrine\Common\Collections\Collection
    {
        return $this->comail;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $comail
     */
    public function setComail(\Doctrine\Common\Collections\Collection $comail): void
    {
        $this->comail = $comail;
    }

}
