<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avenant
 *
 * @ORM\Table(name="avenant", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Avenant
{
    /**
     * @var int
     *
     * @ORM\Column(name="avId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $avid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="avDebut", type="date", nullable=true)
     */
    private $avdebut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avTypeModif", type="text", length=65535, nullable=true)
     */
    private $avtypemodif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avCommentaire", type="text", length=65535, nullable=true)
     */
    private $avcommentaire;

    /**
     * @var \SalarieInfosPro
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
    public function getAvid(): int
    {
        return $this->avid;
    }

    /**
     * @param int $avid
     */
    public function setAvid(int $avid): void
    {
        $this->avid = $avid;
    }

    /**
     * @return \DateTime|null
     */
    public function getAvdebut(): ?\DateTime
    {
        return $this->avdebut;
    }

    /**
     * @param \DateTime|null $avdebut
     */
    public function setAvdebut(?\DateTime $avdebut): void
    {
        $this->avdebut = $avdebut;
    }

    /**
     * @return string|null
     */
    public function getAvtypemodif(): ?string
    {
        return $this->avtypemodif;
    }

    /**
     * @param string|null $avtypemodif
     */
    public function setAvtypemodif(?string $avtypemodif): void
    {
        $this->avtypemodif = $avtypemodif;
    }

    /**
     * @return string|null
     */
    public function getAvcommentaire(): ?string
    {
        return $this->avcommentaire;
    }

    /**
     * @param string|null $avcommentaire
     */
    public function setAvcommentaire(?string $avcommentaire): void
    {
        $this->avcommentaire = $avcommentaire;
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
