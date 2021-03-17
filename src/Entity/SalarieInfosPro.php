<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalarieInfosPro
 *
 * @ORM\Table(name="salarie_infos_pro", indexes={@ORM\Index(name="sPersoId", columns={"sPersoId"})})
 * @ORM\Entity
 */
class SalarieInfosPro
{
    /**
     * @var int
     *
     * @ORM\Column(name="sProId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sproid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNomEmployeur", type="string", length=50, nullable=true)
     */
    private $snomemployeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sMailAsso", type="string", length=100, nullable=true)
     */
    private $smailasso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPosteOccupe", type="string", length=50, nullable=true)
     */
    private $sposteoccupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sCCNS", type="string", length=50, nullable=true)
     */
    private $sccns;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNatureContrat", type="string", length=50, nullable=true)
     */
    private $snaturecontrat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTypeTempsTravail", type="string", length=50, nullable=true)
     */
    private $stypetempstravail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sGestCP", type="string", nullable=true)
     */
    private $sgestcp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateDebut", type="date", nullable=true)
     */
    private $sdatedebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateFin", type="date", nullable=true)
     */
    private $sdatefin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sFinMotif", type="text", length=65535, nullable=true)
     */
    private $sfinmotif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="s10congeMois", type="string", nullable=true)
     */
    private $s10congemois;



    /**
     * @var string|null
     *
     * @ORM\Column(name="sTypeContrat", type="string", length=50, nullable=true)
     */
    private $stypecontrat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sMultiEmployeur", type="string", nullable=true)
     */
    private $smultiemployeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sVolHoraireMois", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $svolhorairemois;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTauxHoraireBrut", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $stauxhorairebrut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sSalMoisBrut", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $ssalmoisbrut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sComplemSante", type="string", nullable=true)
     */
    private $scomplemsante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAutreElement", type="text", length=65535, nullable=true)
     */
    private $sautreelement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sComFin", type="text", length=65535, nullable=true)
     */
    private $scomfin;

    /**
     * @var SalarieInfosPerso
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPerso", inversedBy="sPersoId")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sPersoId", referencedColumnName="sPersoId")
     * })
     */
    private $sPersoId;

    /**
     * @return int
     */
    public function getSproid(): int
    {
        return $this->sproid;
    }

    /**
     * @param int $sproid
     */
    public function setSproid(int $sproid): void
    {
        $this->sproid = $sproid;
    }

    /**
     * @return string|null
     */
    public function getSnomemployeur(): ?string
    {
        return $this->snomemployeur;
    }

    /**
     * @param string|null $snomemployeur
     */
    public function setSnomemployeur(?string $snomemployeur): void
    {
        $this->snomemployeur = $snomemployeur;
    }

    /**
     * @return string|null
     */
    public function getSmailasso(): ?string
    {
        return $this->smailasso;
    }

    /**
     * @param string|null $smailasso
     */
    public function setSmailasso(?string $smailasso): void
    {
        $this->smailasso = $smailasso;
    }

    /**
     * @return string|null
     */
    public function getSposteoccupe(): ?string
    {
        return $this->sposteoccupe;
    }

    /**
     * @param string|null $sposteoccupe
     */
    public function setSposteoccupe(?string $sposteoccupe): void
    {
        $this->sposteoccupe = $sposteoccupe;
    }

    /**
     * @return string|null
     */
    public function getSccns(): ?string
    {
        return $this->sccns;
    }

    /**
     * @param string|null $sccns
     */
    public function setSccns(?string $sccns): void
    {
        $this->sccns = $sccns;
    }

    /**
     * @return string|null
     */
    public function getSnaturecontrat(): ?string
    {
        return $this->snaturecontrat;
    }

    /**
     * @param string|null $snaturecontrat
     */
    public function setSnaturecontrat(?string $snaturecontrat): void
    {
        $this->snaturecontrat = $snaturecontrat;
    }

    /**
     * @return string|null
     */
    public function getStypetempstravail(): ?string
    {
        return $this->stypetempstravail;
    }

    /**
     * @param string|null $stypetempstravail
     */
    public function setStypetempstravail(?string $stypetempstravail): void
    {
        $this->stypetempstravail = $stypetempstravail;
    }

    /**
     * @return string|null
     */
    public function getSgestcp(): ?string
    {
        return $this->sgestcp;
    }

    /**
     * @param string|null $sgestcp
     */
    public function setSgestcp(?string $sgestcp): void
    {
        $this->sgestcp = $sgestcp;
    }

    /**
     * @return \DateTime|null
     */
    public function getSdatedebut(): ?\DateTime
    {
        return $this->sdatedebut;
    }

    /**
     * @param \DateTime|null $sdatedebut
     */
    public function setSdatedebut(?\DateTime $sdatedebut): void
    {
        $this->sdatedebut = $sdatedebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getSdatefin(): ?\DateTime
    {
        return $this->sdatefin;
    }

    /**
     * @param \DateTime|null $sdatefin
     */
    public function setSdatefin(?\DateTime $sdatefin): void
    {
        $this->sdatefin = $sdatefin;
    }

    /**
     * @return string|null
     */
    public function getSfinmotif(): ?string
    {
        return $this->sfinmotif;
    }

    /**
     * @param string|null $sfinmotif
     */
    public function setSfinmotif(?string $sfinmotif): void
    {
        $this->sfinmotif = $sfinmotif;
    }

    /**
     * @return string|null
     */
    public function getS10congemois(): ?string
    {
        return $this->s10congemois;
    }

    /**
     * @param string|null $s10congemois
     */
    public function setS10congemois(?string $s10congemois): void
    {
        $this->s10congemois = $s10congemois;
    }



    /**
     * @return string|null
     */
    public function getStypecontrat(): ?string
    {
        return $this->stypecontrat;
    }

    /**
     * @param string|null $stypecontrat
     */
    public function setStypecontrat(?string $stypecontrat): void
    {
        $this->stypecontrat = $stypecontrat;
    }

    /**
     * @return string|null
     */
    public function getSmultiemployeur(): ?string
    {
        return $this->smultiemployeur;
    }

    /**
     * @param string|null $smultiemployeur
     */
    public function setSmultiemployeur(?string $smultiemployeur): void
    {
        $this->smultiemployeur = $smultiemployeur;
    }

    /**
     * @return string|null
     */
    public function getSvolhorairemois(): ?string
    {
        return $this->svolhorairemois;
    }

    /**
     * @param string|null $svolhorairemois
     */
    public function setSvolhorairemois(?string $svolhorairemois): void
    {
        $this->svolhorairemois = $svolhorairemois;
    }

    /**
     * @return string|null
     */
    public function getStauxhorairebrut(): ?string
    {
        return $this->stauxhorairebrut;
    }

    /**
     * @param string|null $stauxhorairebrut
     */
    public function setStauxhorairebrut(?string $stauxhorairebrut): void
    {
        $this->stauxhorairebrut = $stauxhorairebrut;
    }

    /**
     * @return string|null
     */
    public function getSsalmoisbrut(): ?string
    {
        return $this->ssalmoisbrut;
    }

    /**
     * @param string|null $ssalmoisbrut
     */
    public function setSsalmoisbrut(?string $ssalmoisbrut): void
    {
        $this->ssalmoisbrut = $ssalmoisbrut;
    }

    /**
     * @return string|null
     */
    public function getScomplemsante(): ?string
    {
        return $this->scomplemsante;
    }

    /**
     * @param string|null $scomplemsante
     */
    public function setScomplemsante(?string $scomplemsante): void
    {
        $this->scomplemsante = $scomplemsante;
    }

    /**
     * @return string|null
     */
    public function getSautreelement(): ?string
    {
        return $this->sautreelement;
    }

    /**
     * @param string|null $sautreelement
     */
    public function setSautreelement(?string $sautreelement): void
    {
        $this->sautreelement = $sautreelement;
    }

    /**
     * @return string|null
     */
    public function getScomfin(): ?string
    {
        return $this->scomfin;
    }

    /**
     * @param string|null $scomfin
     */
    public function setScomfin(?string $scomfin): void
    {
        $this->scomfin = $scomfin;
    }

    /*######################## SALARIE INFO PERSO ########################*/

    /**
     * @return SalarieInfosPerso
     */
    public function getSPersoId(): SalarieInfosPerso
    {
        return $this->sPersoId;
    }

    /**
     * @param SalarieInfosPerso $sPersoId
     */
    public function setSPersoId(SalarieInfosPerso $sPersoId): void
    {
        $this->sPersoId = $sPersoId;
    }



}
