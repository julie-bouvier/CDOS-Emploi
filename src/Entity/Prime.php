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
     * @var int|null
     *
     * @ORM\Column(name="primNetBrut", type="integer", nullable=true)
     */
    private $primnetbrut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="primCommentaire", type="text", length=65535, nullable=true)
     */
    private $primcommentaire;

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
