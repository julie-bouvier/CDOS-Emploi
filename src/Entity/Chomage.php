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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var \SalarieInfosPro
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sProId", referencedColumnName="sProId")
     * })
     */
    private $sproid;


}
