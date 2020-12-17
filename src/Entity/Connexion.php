<?php

namespace App\Entity;

use App\Repository\ConnexionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConnexionRepository::class)
 * @ORM\Table(name="Connexion")
 */
class Connexion
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255, name="email")
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

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

}
