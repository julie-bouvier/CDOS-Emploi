<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prime
 *
 * @ORM\Table(name="prime", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Prime
{
    /**
     * @var int
     *
     * @ORM\Column(name="primId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $primid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="primType", type="string", length=25, nullable=true)
     */
    private $primtype;

    /**
     * @var string|null
     *
     * @ORM\Column(name="primMontant", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $primmontant;

    /**
     * @var String|null
     *
     * @ORM\Column(name="primNetBrut", type="string", nullable=true)
     */
    private $primnetbrut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="primCommentaire", type="text", length=65535, nullable=true)
     */
    private $primcommentaire;

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
    public function getPrimid(): int
    {
        return $this->primid;
    }

    /**
     * @param int $primid
     */
    public function setPrimid(int $primid): void
    {
        $this->primid = $primid;
    }

    /**
     * @return string|null
     */
    public function getPrimtype(): ?string
    {
        return $this->primtype;
    }

    /**
     * @param string|null $primtype
     */
    public function setPrimtype(?string $primtype): void
    {
        $this->primtype = $primtype;
    }



    /**
     * @return string|null
     */
    public function getPrimmontant(): ?string
    {
        return $this->primmontant;
    }

    /**
     * @param string|null $primmontant
     */
    public function setPrimmontant(?string $primmontant): void
    {
        $this->primmontant = $primmontant;
    }

    /**
     * @return String|null
     */
    public function getPrimnetbrut(): ?string
    {
        return $this->primnetbrut;
    }

    /**
     * @param String|null $primnetbrut
     */
    public function setPrimnetbrut(?string $primnetbrut): void
    {
        $this->primnetbrut = $primnetbrut;
    }



    /**
     * @return string|null
     */
    public function getPrimcommentaire(): ?string
    {
        return $this->primcommentaire;
    }

    /**
     * @param string|null $primcommentaire
     */
    public function setPrimcommentaire(?string $primcommentaire): void
    {
        $this->primcommentaire = $primcommentaire;
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
