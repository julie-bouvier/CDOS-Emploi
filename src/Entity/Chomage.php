<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chomage
 *
 * @ORM\Table(name="chomage", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Chomage
{
    /**
     * @var int
     *
     * @ORM\Column(name="choId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $choid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="choDebut", type="date", nullable=true)
     */
    private $chodebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="choFin", type="date", nullable=true)
     */
    private $chofin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="choNbHeure", type="integer", nullable=true)
     */
    private $chonbheure;

    /**
     * @var int|null
     *
     * @ORM\Column(name="choMaintien", type="integer", nullable=true)
     */
    private $chomaintien;

    /**
     * @var string|null
     *
     * @ORM\Column(name="choCommentaire", type="text", length=65535, nullable=true)
     */
    private $chocommentaire;

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

    /**
     * @return int
     */
    public function getChoid(): int
    {
        return $this->choid;
    }

    /**
     * @param int $choid
     */
    public function setChoid(int $choid): void
    {
        $this->choid = $choid;
    }

    /**
     * @return \DateTime|null
     */
    public function getChodebut(): ?\DateTime
    {
        return $this->chodebut;
    }

    /**
     * @param \DateTime|null $chodebut
     */
    public function setChodebut(?\DateTime $chodebut): void
    {
        $this->chodebut = $chodebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getChofin(): ?\DateTime
    {
        return $this->chofin;
    }

    /**
     * @param \DateTime|null $chofin
     */
    public function setChofin(?\DateTime $chofin): void
    {
        $this->chofin = $chofin;
    }

    /**
     * @return int|null
     */
    public function getChonbheure(): ?int
    {
        return $this->chonbheure;
    }

    /**
     * @param int|null $chonbheure
     */
    public function setChonbheure(?int $chonbheure): void
    {
        $this->chonbheure = $chonbheure;
    }

    /**
     * @return int|null
     */
    public function getChomaintien(): ?int
    {
        return $this->chomaintien;
    }

    /**
     * @param int|null $chomaintien
     */
    public function setChomaintien(?int $chomaintien): void
    {
        $this->chomaintien = $chomaintien;
    }

    /**
     * @return string|null
     */
    public function getChocommentaire(): ?string
    {
        return $this->chocommentaire;
    }

    /**
     * @param string|null $chocommentaire
     */
    public function setChocommentaire(?string $chocommentaire): void
    {
        $this->chocommentaire = $chocommentaire;
    }


}
