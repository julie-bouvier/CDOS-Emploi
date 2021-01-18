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
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     */
    private $password;

    /**
     * @ORM\Column(name="roles", type="string")
     */
    private $role;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this; //oui
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /*public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }*/

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

    public function getRoles() :array
    {
        // TODO: Implement getRoles() method.
        $roles= [] ;
        // tout le monde à le role user
        $roles[] = 'ROLE_USER';
        // on  attribut le role super admin ou admin en fonction de la variable $roles
        $roles[] = $this->role;
        return array_unique($roles);
    }
}
