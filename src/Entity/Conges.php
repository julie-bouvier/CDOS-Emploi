<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conges
 *
 * @ORM\Table(name="conges", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Conges
{
    /**
     * @var int
     *
     * @ORM\Column(name="conId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $conid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conType", type="string", length=50, nullable=true)
     */
    private $contype;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="conDernierJour", type="date", nullable=true)
     */
    private $condernierjour;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="conJourReprise", type="date", nullable=true)
     */
    private $conjourreprise;

    /**
     * @var array|null
     *
     * @ORM\Column(name="conJourNormalTrav", type="json", nullable=true)
     */
    private $conjournormaltrav;

    /**
     * @var int|null
     *
     * @ORM\Column(name="conNbJourOuvrablePris", type="integer", nullable=true)
     */
    private $connbjourouvrablepris;

    /**
     * @var string|null
     *
     * @ORM\Column(name="conCommentaire", type="text", length=65535, nullable=true)
     */
    private $concommentaire;

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
    public function getConid(): int
    {
        return $this->conid;
    }

    /**
     * @param int $conid
     */
    public function setConid(int $conid): void
    {
        $this->conid = $conid;
    }

    /**
     * @return string|null
     */
    public function getContype(): ?string
    {
        return $this->contype;
    }

    /**
     * @param string|null $contype
     */
    public function setContype(?string $contype): void
    {
        $this->contype = $contype;
    }

    /**
     * @return \DateTime|null
     */
    public function getCondernierjour(): ?\DateTime
    {
        return $this->condernierjour;
    }

    /**
     * @param \DateTime|null $condernierjour
     */
    public function setCondernierjour(?\DateTime $condernierjour): void
    {
        $this->condernierjour = $condernierjour;
    }

    /**
     * @return \DateTime|null
     */
    public function getConjourreprise(): ?\DateTime
    {
        return $this->conjourreprise;
    }

    /**
     * @param \DateTime|null $conjourreprise
     */
    public function setConjourreprise(?\DateTime $conjourreprise): void
    {
        $this->conjourreprise = $conjourreprise;
    }

    /**
     * @return array|null
     */
    public function getConjournormaltrav(): ?array
    {
        return $this->conjournormaltrav;
    }

    /**
     * @param array|null $conjournormaltrav
     */
    public function setConjournormaltrav(?array $conjournormaltrav): void
    {
        $this->conjournormaltrav = $conjournormaltrav;
    }



    /**
     * @return int|null
     */
    public function getConnbjourouvrablepris(): ?int
    {
        return $this->connbjourouvrablepris;
    }

    /**
     * @param int|null $connbjourouvrablepris
     */
    public function setConnbjourouvrablepris(?int $connbjourouvrablepris): void
    {
        $this->connbjourouvrablepris = $connbjourouvrablepris;
    }

    /**
     * @return string|null
     */
    public function getConcommentaire(): ?string
    {
        return $this->concommentaire;
    }

    /**
     * @param string|null $concommentaire
     */
    public function setConcommentaire(?string $concommentaire): void
    {
        $this->concommentaire = $concommentaire;
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
