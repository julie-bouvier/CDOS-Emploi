<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FAssociation
 *
 * @ORM\Table(name="f_association", indexes={@ORM\Index(name="aMail", columns={"aMail"})})
 * @ORM\Entity
 */
class FAssociation
{
    /**
     * @var int
     *
     * @ORM\Column(name="faId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $faid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faNomUser", type="string", length=25, nullable=true)
     */
    private $fanomuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faNomGen", type="string", length=50, nullable=true)
     */
    private $fanomgen;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faChemin", type="string", length=50, nullable=true)
     */
    private $fachemin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="faDateDepo", type="date", nullable=true)
     */
    private $fadatedepo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="faDateTel", type="date", nullable=true)
     */
    private $fadatetel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="faCategorie", type="string", length=50, nullable=true)
     */
    private $facategorie;

    /**
     * @var \Association
     *
     * @ORM\ManyToOne(targetEntity="Association")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="aMail", referencedColumnName="aMail")
     * })
     */
    private $amail;


}
