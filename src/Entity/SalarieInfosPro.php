<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalarieInfosPro
 *
 * @ORM\Table(name="salarie_infos_pro", indexes={@ORM\Index(name="sPersoId", columns={"sPersoId"})})
 * @ORM\Entity
 */
class SalarieInfosPro
{
    /**
     * @var int
     *
     * @ORM\Column(name="sProId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sproid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNomEmployeur", type="string", length=50, nullable=true)
     */
    private $snomemployeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPosteOccupe", type="string", length=50, nullable=true)
     */
    private $sposteoccupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sCCNS", type="string", length=50, nullable=true)
     */
    private $sccns;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNatureContrat", type="string", length=50, nullable=true)
     */
    private $snaturecontrat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTypeTempsTravail", type="string", length=50, nullable=true)
     */
    private $stypetempstravail;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sGestCP", type="integer", nullable=true)
     */
    private $sgestcp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateDebut", type="date", nullable=true)
     */
    private $sdatedebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateFin", type="date", nullable=true)
     */
    private $sdatefin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sFinMotif", type="text", length=65535, nullable=true)
     */
    private $sfinmotif;

    /**
     * @var int|null
     *
     * @ORM\Column(name="s10congeMois", type="integer", nullable=true)
     */
    private $s10congemois;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sConge", type="integer", nullable=true)
     */
    private $sconge;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTypeContrat", type="string", length=50, nullable=true)
     */
    private $stypecontrat;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sMultiEmployeur", type="integer", nullable=true)
     */
    private $smultiemployeur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sVolHoraireMois", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $svolhorairemois;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTauxHoraireBrut", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $stauxhorairebrut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sSalMoisBrut", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $ssalmoisbrut;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sComplemSante", type="integer", nullable=true)
     */
    private $scomplemsante;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAutreElement", type="text", length=65535, nullable=true)
     */
    private $sautreelement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sComFin", type="text", length=65535, nullable=true)
     */
    private $scomfin;

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
