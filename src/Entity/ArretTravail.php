<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArretTravail
 *
 * @ORM\Table(name="arret_travail", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class ArretTravail
{
    /**
     * @var int
     *
     * @ORM\Column(name="atId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $atid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atType", type="text", length=65535, nullable=true)
     */
    private $attype;

    /**
     * @var int|null
     *
     * @ORM\Column(name="atProlongation", type="integer", nullable=true)
     */
    private $atprolongation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="atDebut", type="date", nullable=true)
     */
    private $atdebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="atFin", type="date", nullable=true)
     */
    private $atfin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at3jours", type="integer", nullable=true)
     */
    private $at3jours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at3jNbH", type="integer", nullable=true)
     */
    private $at3jnbh;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at4jours", type="integer", nullable=true)
     */
    private $at4jours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at4jNbH", type="integer", nullable=true)
     */
    private $at4jnbh;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atCommentaire", type="text", length=65535, nullable=true)
     */
    private $atcommentaire;

    /**
     * @var SalarieInfosPro
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sProId", referencedColumnName="sProId")
     * })
     */
    private $sproid;

    /**
     * @return int
     */
    public function getAtid(): int
    {
        return $this->atid;
    }

    /**
     * @param int $atid
     */
    public function setAtid(int $atid): void
    {
        $this->atid = $atid;
    }

    /**
     * @return string|null
     */
    public function getAttype(): ?string
    {
        return $this->attype;
    }

    /**
     * @param string|null $attype
     */
    public function setAttype(?string $attype): void
    {
        $this->attype = $attype;
    }

    /**
     * @return int|null
     */
    public function getAtprolongation(): ?int
    {
        return $this->atprolongation;
    }

    /**
     * @param int|null $atprolongation
     */
    public function setAtprolongation(?int $atprolongation): void
    {
        $this->atprolongation = $atprolongation;
    }

    /**
     * @return \DateTime|null
     */
    public function getAtdebut(): ?\DateTime
    {
        return $this->atdebut;
    }

    /**
     * @param \DateTime|null $atdebut
     */
    public function setAtdebut(?\DateTime $atdebut): void
    {
        $this->atdebut = $atdebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getAtfin(): ?\DateTime
    {
        return $this->atfin;
    }

    /**
     * @param \DateTime|null $atfin
     */
    public function setAtfin(?\DateTime $atfin): void
    {
        $this->atfin = $atfin;
    }

    /**
     * @return int|null
     */
    public function getAt3jours(): ?int
    {
        return $this->at3jours;
    }

    /**
     * @param int|null $at3jours
     */
    public function setAt3jours(?int $at3jours): void
    {
        $this->at3jours = $at3jours;
    }

    /**
     * @return int|null
     */
    public function getAt3jnbh(): ?int
    {
        return $this->at3jnbh;
    }

    /**
     * @param int|null $at3jnbh
     */
    public function setAt3jnbh(?int $at3jnbh): void
    {
        $this->at3jnbh = $at3jnbh;
    }

    /**
     * @return int|null
     */
    public function getAt4jours(): ?int
    {
        return $this->at4jours;
    }

    /**
     * @param int|null $at4jours
     */
    public function setAt4jours(?int $at4jours): void
    {
        $this->at4jours = $at4jours;
    }

    /**
     * @return int|null
     */
    public function getAt4jnbh(): ?int
    {
        return $this->at4jnbh;
    }

    /**
     * @param int|null $at4jnbh
     */
    public function setAt4jnbh(?int $at4jnbh): void
    {
        $this->at4jnbh = $at4jnbh;
    }

    /**
     * @return string|null
     */
    public function getAtcommentaire(): ?string
    {
        return $this->atcommentaire;
    }

    /**
     * @param string|null $atcommentaire
     */
    public function setAtcommentaire(?string $atcommentaire): void
    {
        $this->atcommentaire = $atcommentaire;
    }

    /**
     * @return SalarieInfosPro
     */
    public function getSproid(): SalarieInfosPro
    {
        return $this->sproid;
    }

    /**
     * @param SalarieInfosPro $sproid
     */
    public function setSproid(SalarieInfosPro $sproid): void
    {
        $this->sproid = $sproid;
    }


}
