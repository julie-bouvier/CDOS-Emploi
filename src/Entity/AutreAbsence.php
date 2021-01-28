<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutreAbsence
 *
 * @ORM\Table(name="autre_absence", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class AutreAbsence
{
    /**
     * @var int
     *
     * @ORM\Column(name="absId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $absid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="absDebut", type="date", nullable=true)
     */
    private $absdebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="absFin", type="date", nullable=true)
     */
    private $absfin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="absNbHeure", type="integer", nullable=true)
     */
    private $absnbheure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="absCommentaire", type="text", length=65535, nullable=true)
     */
    private $abscommentaire;

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
    public function getAbsid(): int
    {
        return $this->absid;
    }

    /**
     * @param int $absid
     */
    public function setAbsid(int $absid): void
    {
        $this->absid = $absid;
    }

    /**
     * @return \DateTime|null
     */
    public function getAbsdebut(): ?\DateTime
    {
        return $this->absdebut;
    }

    /**
     * @param \DateTime|null $absdebut
     */
    public function setAbsdebut(?\DateTime $absdebut): void
    {
        $this->absdebut = $absdebut;
    }

    /**
     * @return \DateTime|null
     */
    public function getAbsfin(): ?\DateTime
    {
        return $this->absfin;
    }

    /**
     * @param \DateTime|null $absfin
     */
    public function setAbsfin(?\DateTime $absfin): void
    {
        $this->absfin = $absfin;
    }

    /**
     * @return int|null
     */
    public function getAbsnbheure(): ?int
    {
        return $this->absnbheure;
    }

    /**
     * @param int|null $absnbheure
     */
    public function setAbsnbheure(?int $absnbheure): void
    {
        $this->absnbheure = $absnbheure;
    }

    /**
     * @return string|null
     */
    public function getAbscommentaire(): ?string
    {
        return $this->abscommentaire;
    }

    /**
     * @param string|null $abscommentaire
     */
    public function setAbscommentaire(?string $abscommentaire): void
    {
        $this->abscommentaire = $abscommentaire;
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
