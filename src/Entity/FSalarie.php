<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FSalarie
 *
 * @ORM\Table(name="f_salarie", indexes={@ORM\Index(name="sPersoId", columns={"sPersoId"})})
 * @ORM\Entity
 */
class FSalarie
{
    /**
     * @var int
     *
     * @ORM\Column(name="fsId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $fsid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fsNomUser", type="string", length=50, nullable=true)
     */
    private $fsnomuser;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fsNomGen", type="string", length=50, nullable=true)
     */
    private $fsnomgen;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fsChemin", type="string", length=50, nullable=true)
     */
    private $fschemin;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fsDateDepo", type="date", nullable=true)
     */
    private $fsdatedepo;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fsDateTel", type="date", nullable=true)
     */
    private $fsdatetel;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fsCategorie", type="string", length=50, nullable=true)
     */
    private $fscategorie;

    /**
     * @var \SalarieInfosPerso
     *
     * @ORM\ManyToOne(targetEntity="SalarieInfosPerso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sPersoId", referencedColumnName="sPersoId")
     * })
     */
    private $spersoid;


}
