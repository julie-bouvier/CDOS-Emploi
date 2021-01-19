<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avenant
 *
 * @ORM\Table(name="avenant", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class Avenant
{
    /**
     * @var int
     *
     * @ORM\Column(name="avId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $avid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="avDebut", type="date", nullable=true)
     */
    private $avdebut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avTypeModif", type="text", length=65535, nullable=true)
     */
    private $avtypemodif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avCommentaire", type="text", length=65535, nullable=true)
     */
    private $avcommentaire;

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
