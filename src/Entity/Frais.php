<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Frais
 *
 * @ORM\Table(name="frais", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Frais
{
    /**
     * @var int
     *
     * @ORM\Column(name="fraId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $fraid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fraType", type="string", length=25, nullable=true)
     */
    private $fratype;

    /**
     * @var int|null
     *
     * @ORM\Column(name="fraQuantite", type="integer", nullable=true)
     */
    private $fraquantite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fraTaux", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $frataux;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fraTotal", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $fratotal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fraCommentaire", type="text", length=65535, nullable=true)
     */
    private $fracommentaire;

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
    public function getFraid(): int
    {
        return $this->fraid;
    }

    /**
     * @param int $fraid
     */
    public function setFraid(int $fraid): void
    {
        $this->fraid = $fraid;
    }

    /**
     * @return string|null
     */
    public function getFratype(): ?string
    {
        return $this->fratype;
    }

    /**
     * @param string|null $fratype
     */
    public function setFratype(?string $fratype): void
    {
        $this->fratype = $fratype;
    }

    /**
     * @return int|null
     */
    public function getFraquantite(): ?int
    {
        return $this->fraquantite;
    }

    /**
     * @param int|null $fraquantite
     */
    public function setFraquantite(?int $fraquantite): void
    {
        $this->fraquantite = $fraquantite;
    }

    /**
     * @return string|null
     */
    public function getFrataux(): ?string
    {
        return $this->frataux;
    }

    /**
     * @param string|null $frataux
     */
    public function setFrataux(?string $frataux): void
    {
        $this->frataux = $frataux;
    }

    /**
     * @return string|null
     */
    public function getFratotal(): ?string
    {
        return $this->fratotal;
    }

    /**
     * @param string|null $fratotal
     */
    public function setFratotal(?string $fratotal): void
    {
        $this->fratotal = $fratotal;
    }

    /**
     * @return string|null
     */
    public function getFracommentaire(): ?string
    {
        return $this->fracommentaire;
    }

    /**
     * @param string|null $fracommentaire
     */
    public function setFracommentaire(?string $fracommentaire): void
    {
        $this->fracommentaire = $fracommentaire;
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
