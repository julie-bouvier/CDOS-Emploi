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


    /**
     * @return int
     */
    public function getFsid(): int
    {
        return $this->fsid;
    }

    /**
     * @param int $fsid
     */
    public function setFsid(int $fsid): void
    {
        $this->fsid = $fsid;
    }

    /**
     * @return string|null
     */
    public function getFsnomuser(): ?string
    {
        return $this->fsnomuser;
    }

    /**
     * @param string|null $fsnomuser
     */
    public function setFsnomuser(?string $fsnomuser): void
    {
        $this->fsnomuser = $fsnomuser;
    }

    /**
     * @return string|null
     */
    public function getFsnomgen(): ?string
    {
        return $this->fsnomgen;
    }

    /**
     * @param string|null $fsnomgen
     */
    public function setFsnomgen(?string $fsnomgen): void
    {
        $this->fsnomgen = $fsnomgen;
    }

    /**
     * @return string|null
     */
    public function getFschemin(): ?string
    {
        return $this->fschemin;
    }

    /**
     * @param string|null $fschemin
     */
    public function setFschemin(?string $fschemin): void
    {
        $this->fschemin = $fschemin;
    }

    /**
     * @return \DateTime|null
     */
    public function getFsdatedepo(): ?\DateTime
    {
        return $this->fsdatedepo;
    }

    /**
     * @param \DateTime|null $fsdatedepo
     */
    public function setFsdatedepo(?\DateTime $fsdatedepo): void
    {
        $this->fsdatedepo = $fsdatedepo;
    }

    /**
     * @return \DateTime|null
     */
    public function getFsdatetel(): ?\DateTime
    {
        return $this->fsdatetel;
    }

    /**
     * @param \DateTime|null $fsdatetel
     */
    public function setFsdatetel(?\DateTime $fsdatetel): void
    {
        $this->fsdatetel = $fsdatetel;
    }

    /**
     * @return string|null
     */
    public function getFscategorie(): ?string
    {
        return $this->fscategorie;
    }

    /**
     * @param string|null $fscategorie
     */
    public function setFscategorie(?string $fscategorie): void
    {
        $this->fscategorie = $fscategorie;
    }

    /**
     * @return \SalarieInfosPerso
     */
    public function getSpersoid(): \SalarieInfosPerso
    {
        return $this->spersoid;
    }

    /**
     * @param \SalarieInfosPerso $spersoid
     */
    public function setSpersoid(\SalarieInfosPerso $spersoid): void
    {
        $this->spersoid = $spersoid;
    }




}
