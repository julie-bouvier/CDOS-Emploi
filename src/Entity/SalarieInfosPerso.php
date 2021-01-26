<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SalarieInfosPerso
 *
 * @ORM\Table(name="salarie_infos_perso")
 * @ORM\Entity
 */
class SalarieInfosPerso
{
    /**
     * @var int
     *
     * @ORM\Column(name="sPersoId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $spersoid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNom", type="string", length=50, nullable=true)
     */
    private $snom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNomJeuneFille", type="string", length=50, nullable=true)
     */
    private $snomjeunefille;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPrenom", type="string", length=50, nullable=true)
     */
    private $sprenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAdresse", type="text", length=65535, nullable=true)
     */
    private $sadresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPortable", type="string", length=20, nullable=true)
     */
    private $sportable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTel", type="string", length=25, nullable=true)
     */
    private $stel;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateNaissance", type="date", nullable=true)
     */
    private $sdatenaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sLieuNaissance", type="text", length=65535, nullable=true)
     */
    private $slieunaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sDptNaissance", type="integer", nullable=true)
     */
    private $sdptnaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNationalite", type="integer", nullable=true)
     */
    private $snationalite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAutre", type="string", length=50, nullable=true)
     */
    private $sautre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNumSecu", type="integer", nullable=true)
     */
    private $snumsecu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sSituationFam", type="string", length=100, nullable=true)
     */
    private $ssituationfam;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNbEnfant", type="integer", nullable=true)
     */
    private $snbenfant;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Association", mappedBy="salarieinfosperso")
     */
    private $amail;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="SalarieInfosPro", mappedBy="sPersoId")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sproid", referencedColumnName="sProId")
     * })
     */
    private $sproid;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amail = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getSpersoid(): int
    {
        return $this->spersoid;
    }

    /**
     * @param int $spersoid
     */
    public function setSpersoid(int $spersoid): void
    {
        $this->spersoid = $spersoid;
    }

    /**
     * @return string|null
     */
    public function getSnom(): ?string
    {
        return $this->snom;
    }

    /**
     * @param string|null $snom
     */
    public function setSnom(?string $snom): void
    {
        $this->snom = $snom;
    }

    /**
     * @return string|null
     */
    public function getSnomjeunefille(): ?string
    {
        return $this->snomjeunefille;
    }

    /**
     * @param string|null $snomjeunefille
     */
    public function setSnomjeunefille(?string $snomjeunefille): void
    {
        $this->snomjeunefille = $snomjeunefille;
    }

    /**
     * @return string|null
     */
    public function getSprenom(): ?string
    {
        return $this->sprenom;
    }

    /**
     * @param string|null $sprenom
     */
    public function setSprenom(?string $sprenom): void
    {
        $this->sprenom = $sprenom;
    }

    /**
     * @return string|null
     */
    public function getSadresse(): ?string
    {
        return $this->sadresse;
    }

    /**
     * @param string|null $sadresse
     */
    public function setSadresse(?string $sadresse): void
    {
        $this->sadresse = $sadresse;
    }

    /**
     * @return string|null
     */
    public function getSportable(): ?string
    {
        return $this->sportable;
    }

    /**
     * @param string|null $sportable
     */
    public function setSportable(?string $sportable): void
    {
        $this->sportable = $sportable;
    }

    /**
     * @return string|null
     */
    public function getStel(): ?string
    {
        return $this->stel;
    }

    /**
     * @param string|null $stel
     */
    public function setStel(?string $stel): void
    {
        $this->stel = $stel;
    }

    /**
     * @return \DateTime|null
     */
    public function getSdatenaissance(): ?\DateTime
    {
        return $this->sdatenaissance;
    }

    /**
     * @param \DateTime|null $sdatenaissance
     */
    public function setSdatenaissance(?\DateTime $sdatenaissance): void
    {
        $this->sdatenaissance = $sdatenaissance;
    }

    /**
     * @return string|null
     */
    public function getSlieunaissance(): ?string
    {
        return $this->slieunaissance;
    }

    /**
     * @param string|null $slieunaissance
     */
    public function setSlieunaissance(?string $slieunaissance): void
    {
        $this->slieunaissance = $slieunaissance;
    }

    /**
     * @return int|null
     */
    public function getSdptnaissance(): ?int
    {
        return $this->sdptnaissance;
    }

    /**
     * @param int|null $sdptnaissance
     */
    public function setSdptnaissance(?int $sdptnaissance): void
    {
        $this->sdptnaissance = $sdptnaissance;
    }

    /**
     * @return int|null
     */
    public function getSnationalite(): ?int
    {
        return $this->snationalite;
    }

    /**
     * @param int|null $snationalite
     */
    public function setSnationalite(?int $snationalite): void
    {
        $this->snationalite = $snationalite;
    }

    /**
     * @return string|null
     */
    public function getSautre(): ?string
    {
        return $this->sautre;
    }

    /**
     * @param string|null $sautre
     */
    public function setSautre(?string $sautre): void
    {
        $this->sautre = $sautre;
    }

    /**
     * @return int|null
     */
    public function getSnumsecu(): ?int
    {
        return $this->snumsecu;
    }

    /**
     * @param int|null $snumsecu
     */
    public function setSnumsecu(?int $snumsecu): void
    {
        $this->snumsecu = $snumsecu;
    }

    /**
     * @return string|null
     */
    public function getSsituationfam(): ?string
    {
        return $this->ssituationfam;
    }

    /**
     * @param string|null $ssituationfam
     */
    public function setSsituationfam(?string $ssituationfam): void
    {
        $this->ssituationfam = $ssituationfam;
    }

    /**
     * @return int|null
     */
    public function getSnbenfant(): ?int
    {
        return $this->snbenfant;
    }

    /**
     * @param int|null $snbenfant
     */
    public function setSnbenfant(?int $snbenfant): void
    {
        $this->snbenfant = $snbenfant;
    }

    /*######################## ASSOCIATIONS ########################*/

    /**
     * @return Collection
     */
    public function getAmail(): Collection
    {
        return $this->amail;
    }

    /**
     * @param Collection $amail
     */
    public function setAmail(Collection $amail): void
    {
        $this->amail = $amail;
    }

    /**
     * @param Association $association
     */
    public function addAssociation(Association $association): void
    {
        $this->amail->add($association);
    }

    /**
     * @param Association $association
     */
    public function removeAssociation(Association $association):void
    {
        $this->amail->remove($association);
    }

    /*######################## SALARIE INFO PRO ########################*/

    /**
     * @return Collection
     */
    public function getSproid(): Collection
    {
        return $this->sproid;
    }

    /**
     * @param Collection $sproid
     */
    public function setSproid(Collection $sproid): void
    {
        $this->sproid = $sproid;
    }

    /**
     * @param SalarieInfosPro $salarieinfospro
     */
    public function addSalarieinfospro(SalarieInfosPro $salarieinfospro): void
    {
        $this->sproid->add($salarieinfospro);
    }

    /**
     * @param SalarieInfosPro $salarieinfospro
     */
    public function removeSalarieinfospro(SalarieInfosPro $salarieinfospro):void
    {
        $this->sproid->remove($salarieinfospro);
    }

}
