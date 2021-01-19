<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutreAbsence
 *
 * @ORM\Table(name="autre_absence", indexes={@ORM\Index(name="sProId", columns={"sProId"})})
 * @ORM\Entity
 */
class AutreAbsence
{
    /**
     * @var int
     *
     * @ORM\Column(name="absId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $absid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="absDebut", type="date", nullable=true)
     */
    private $absdebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="absFin", type="date", nullable=true)
     */
    private $absfin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="absNbHeure", type="integer", nullable=true)
     */
    private $absnbheure;

    /**
     * @var string|null
     *
     * @ORM\Column(name="absCommentaire", type="text", length=65535, nullable=true)
     */
    private $abscommentaire;

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
