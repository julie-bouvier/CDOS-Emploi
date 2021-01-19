<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalarieInfosPerso
 *
 * @ORM\Table(name="salarie_infos_perso")
 * @ORM\Entity
 */
class SalarieInfosPerso
{
    /**
     * @var int
     *
     * @ORM\Column(name="sPersoId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $spersoid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNom", type="string", length=50, nullable=true)
     */
    private $snom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sNomJeuneFille", type="string", length=50, nullable=true)
     */
    private $snomjeunefille;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPrenom", type="string", length=50, nullable=true)
     */
    private $sprenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAdresse", type="text", length=65535, nullable=true)
     */
    private $sadresse;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sPortable", type="string", length=20, nullable=true)
     */
    private $sportable;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sTel", type="string", length=25, nullable=true)
     */
    private $stel;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sDateNaissance", type="date", nullable=true)
     */
    private $sdatenaissance;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sLieuNaissance", type="text", length=65535, nullable=true)
     */
    private $slieunaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sDptNaissance", type="integer", nullable=true)
     */
    private $sdptnaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNationalite", type="integer", nullable=true)
     */
    private $snationalite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sAutre", type="string", length=50, nullable=true)
     */
    private $sautre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNumSecu", type="integer", nullable=true)
     */
    private $snumsecu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sSituationFam", type="string", length=100, nullable=true)
     */
    private $ssituationfam;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sNbEnfant", type="integer", nullable=true)
     */
    private $snbenfant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Association", mappedBy="spersoid")
     */
    private $amail;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amail = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
