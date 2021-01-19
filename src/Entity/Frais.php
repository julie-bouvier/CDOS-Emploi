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


}
