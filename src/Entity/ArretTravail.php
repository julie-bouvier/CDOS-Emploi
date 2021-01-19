<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArretTravail
 *
 * @ORM\Table(name="arret_travail", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class ArretTravail
{
    /**
     * @var int
     *
     * @ORM\Column(name="atId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $atid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atType", type="text", length=65535, nullable=true)
     */
    private $attype;

    /**
     * @var int|null
     *
     * @ORM\Column(name="atProlongation", type="integer", nullable=true)
     */
    private $atprolongation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="atDebut", type="date", nullable=true)
     */
    private $atdebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="atFin", type="date", nullable=true)
     */
    private $atfin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at3jours", type="integer", nullable=true)
     */
    private $at3jours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at3jNbH", type="integer", nullable=true)
     */
    private $at3jnbh;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at4jours", type="integer", nullable=true)
     */
    private $at4jours;

    /**
     * @var int|null
     *
     * @ORM\Column(name="at4jNbH", type="integer", nullable=true)
     */
    private $at4jnbh;

    /**
     * @var string|null
     *
     * @ORM\Column(name="atCommentaire", type="text", length=65535, nullable=true)
     */
    private $atcommentaire;

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
