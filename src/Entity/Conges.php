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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var string|null
     *
     * @ORM\Column(name="conJourNormalTrav", type="string", length=100, nullable=true)
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
     * @var \SalarieInfosPro
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sProId", referencedColumnName="sProId")
     * })
     */
    private $sproid;


}
