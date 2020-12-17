<?php

namespace App\Entity;

use App\Repository\ConnexionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConnexionRepository::class)
 * @ORM\Table(name="Connexion")
 * @UniqueEntity(fields={"email"},message="Cet email est déjà enregisté")
 */
class Connexion implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255, name="email", unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(min=8)
     */
    private $password;

    /**
     * @ORM\Column(name="superAdmin", type="boolean")
     */
    private $SuperAdmin;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSuperAdmin(): ?bool
    {
        return $this->SuperAdmin;
    }

    public function setSuperAdmin(bool $SuperAdmin): self
    {
        $this->SuperAdmin = $SuperAdmin;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return ['Role_USER'];
    }
}
