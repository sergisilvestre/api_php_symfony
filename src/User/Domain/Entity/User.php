<?php

namespace App\User\Domain\Entity;


final class User
{
    /**
     * @param string[] $verifications
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private string $password
    ) {}

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
