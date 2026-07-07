<?php

namespace App\User\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class UserRecord implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;


    public function id(): ?int
    {
        return $this->id;
    }


    public function name(): string
    {
        return $this->name;
    }


    public function email(): string
    {
        return $this->email;
    }


    public function password(): string
    {
        return $this->password;
    }


    // Symfony Security methods

    public function getUserIdentifier(): string
    {
        return $this->email;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function getRoles(): array
    {
        return [
            'ROLE_USER'
        ];
    }


    public function eraseCredentials(): void
    {
        // Clear temporary sensitive data if you add any later
    }


    // Domain methods

    public function changeName(string $name): void
    {
        $this->name = $name;
    }


    public function changeEmail(string $email): void
    {
        $this->email = $email;
    }


    public function changePassword(string $password): void
    {
        $this->password = $password;
    }
}