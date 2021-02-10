<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FAssociation
 *
 * @ORM\Table(name="f_association", indexes={@ORM\Index(name="aMail", columns={"aMail"})})
 * @ORM\Entity
 */
class FAssociation
{
    /**
     * @var int
     *
     * @ORM\Column(name="faId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faNomUser", type="string", length=25, nullable=true)
     */
    private $fanomuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faNomGen", type="string", length=50, nullable=true)
     */
    private $fanomgen;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faChemin", type="string", length=50, nullable=true)
     */
    private $fachemin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="faDateDepo", type="date", nullable=true)
     */
    private $fadatedepo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="faDateTel", type="date", nullable=true)
     */
    private $fadatetel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faCategorie", type="string", length=50, nullable=true)
     */
    private $facategorie;

    /**
     * @var \Association
     *
     * @ORM\ManyToOne(targetEntity="Association")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aMail", referencedColumnName="aMail")
     * })
     */
    private $amail;



    /**
     * @return int
     */
    public function getFaid(): int
    {
        return $this->faid;
    }

    /**
     * @param int $faid
     */
    public function setFaid(int $faid): void
    {
        $this->faid = $faid;
    }

    /**
     * @return string|null
     */
    public function getFanomuser(): ?string
    {
        return $this->fanomuser;
    }

    /**
     * @param string|null $fanomuser
     */
    public function setFanomuser(?string $fanomuser): void
    {
        $this->fanomuser = $fanomuser;
    }

    /**
     * @return string|null
     */
    public function getFanomgen(): ?string
    {
        return $this->fanomgen;
    }

    /**
     * @param string|null $fanomgen
     */
    public function setFanomgen(?string $fanomgen): void
    {
        $this->fanomgen = $fanomgen;
    }

    /**
     * @return string|null
     */
    public function getFachemin(): ?string
    {
        return $this->fachemin;
    }

    /**
     * @param string|null $fachemin
     */
    public function setFachemin(?string $fachemin): void
    {
        $this->fachemin = $fachemin;
    }

    /**
     * @return \DateTime|null
     */
    public function getFadatedepo(): ?\DateTime
    {
        return $this->fadatedepo;
    }

    /**
     * @param \DateTime|null $fadatedepo
     */
    public function setFadatedepo(?\DateTime $fadatedepo): void
    {
        $this->fadatedepo = $fadatedepo;
    }

    /**
     * @return \DateTime|null
     */
    public function getFadatetel(): ?\DateTime
    {
        return $this->fadatetel;
    }

    /**
     * @param \DateTime|null $fadatetel
     */
    public function setFadatetel(?\DateTime $fadatetel): void
    {
        $this->fadatetel = $fadatetel;
    }

    /**
     * @return string|null
     */
    public function getFacategorie(): ?string
    {
        return $this->facategorie;
    }

    /**
     * @param string|null $facategorie
     */
    public function setFacategorie(?string $facategorie): void
    {
        $this->facategorie = $facategorie;
    }

    /**
     * @return \Association
     */
    public function getAmail(): \Association
    {
        return $this->amail;
    }

    /**
     * @param \Association $amail
     */
    public function setAmail(\Association $amail): void
    {
        $this->amail = $amail;
    }

}
