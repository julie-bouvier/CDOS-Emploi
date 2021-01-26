<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Connexion
 *
 * @ORM\Table(name="connexion")
 * @ORM\Entity
 */
class Connexion implements \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="coMail", type="string", length=25, nullable=false)
     * @ORM\Id
     */
    private $comail;

    /**
     * @var string
     *
     * @ORM\Column(name="coMdp", type="string", length=25, nullable=false)
     */
    private $comdp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coNom", type="string", length=25, nullable=true)
     */
    private $conom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="coRoles", type="string", length=50, nullable=true)
     */
    private $coroles;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Association", mappedBy="comail")
     */
    private $associations;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->associations = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * GETTER & SETTER
     */



    /**
     * @return string
     */
    public function getComail(): string
    {
        return $this->comail;
    }

    /**
     * @param string $comail
     */
    public function setComail(string $comail): void
    {
        $this->comail = $comail;
    }

    /**
     * @return string
     */
    public function getComdp(): string
    {
        return $this->comdp;
    }

    /**
     * @param string $comdp
     */
    public function setComdp(string $comdp): void
    {
        $this->comdp = $comdp;
    }

    /**
     * @return string|null
     */
    public function getConom(): ?string
    {
        return $this->conom;
    }

    /**
     * @param string|null $conom
     */
    public function setConom(?string $conom): void
    {
        $this->conom = $conom;
    }

    /**
     * @return string|null
     */
    public function getCoroles(): ?string
    {
        return $this->coroles;
    }

    /**
     * @param string|null $coroles
     */
    public function setCoroles(?string $coroles): void
    {
        $this->coroles = $coroles;
    }

    /*######################## ASSOCIATIONS ########################*/

    /**
     * @return Collection
     */
    public function getassociations()
    {
        return $this->associations;
    }

    /**
     * @param Collection $associations
     */
    public function setassociations($associations): void
    {
        $this->associations = $associations;
    }

    /**
     * @param Association $association
     */
    public function addAssociation(Association $association): void
    {
        $this->associations->add($association);
    }

    /**
     * @param Association $association
     */
    public function removeAssociation(Association $association):void
    {
        $this->associations->remove($association);
    }

    /*######################## FONCTIONS INDISPENSABLES POUR LA CONNEXION ########################*/

    public function getPassword(): ?string
    {
        return $this->comdp;
    }

    public function getUsername(): ?string
    {
        return $this->comail;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getRoles() :array
    {
        // TODO: Implement getRoles() method.
        $roles= [] ;
        // tout le monde à le role user
        $roles[] = 'ROLE_USER';
        // on  attribut le role super Sadmin ou Sadmin en fonction de la variable $roles
        $roles[] = $this->coroles;
        return array_unique($roles);
    }

}
