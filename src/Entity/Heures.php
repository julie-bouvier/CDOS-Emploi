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
     * @var \DateTime|null
     *
     * @ORM\Column(name="heurSem", type="date", nullable=true)
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
     * @var \SalarieInfosPro
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sProId", referencedColumnName="sProId")
     * })
     */
    private $sproid;


}
