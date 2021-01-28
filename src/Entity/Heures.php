<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Heures
 *
 * @ORM\Table(name="heures", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Heures
{
    /**
     * @var int
     *
     * @ORM\Column(name="heurId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $heurid;

    /**
     * @var String|null
     *
     * @ORM\Column(name="heurType", type="string", length=25,  nullable=true)
     */
    private $heurtype;

    /**
     * @var int|null
     *
     * @ORM\Column(name="heurSem", type="integer", nullable=true)
     */
    private $heursem;

    /**
     * @var int|null
     *
     * @ORM\Column(name="heurNb", type="integer", nullable=true)
     */
    private $heurnb;

    /**
     * @var string|null
     *
     * @ORM\Column(name="heurCommentaire", type="text", length=65535, nullable=true)
     */
    private $heurcommentaire;

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
    public function getHeurid(): int
    {
        return $this->heurid;
    }

    /**
     * @param int $heurid
     */
    public function setHeurid(int $heurid): void
    {
        $this->heurid = $heurid;
    }

    /**
     * @return String|null
     */
    public function getHeurtype(): ?string
    {
        return $this->heurtype;
    }

    /**
     * @param String|null $heurtype
     */
    public function setHeurtype(?string $heurtype): void
    {
        $this->heurtype = $heurtype;
    }

    /**
     * @return int|null
     */
    public function getHeursem(): ?int
    {
        return $this->heursem;
    }

    /**
     * @param int|null $heursem
     */
    public function setHeursem(?int $heursem): void
    {
        $this->heursem = $heursem;
    }



    /**
     * @return int|null
     */
    public function getHeurnb(): ?int
    {
        return $this->heurnb;
    }

    /**
     * @param int|null $heurnb
     */
    public function setHeurnb(?int $heurnb): void
    {
        $this->heurnb = $heurnb;
    }

    /**
     * @return string|null
     */
    public function getHeurcommentaire(): ?string
    {
        return $this->heurcommentaire;
    }

    /**
     * @param string|null $heurcommentaire
     */
    public function setHeurcommentaire(?string $heurcommentaire): void
    {
        $this->heurcommentaire = $heurcommentaire;
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
