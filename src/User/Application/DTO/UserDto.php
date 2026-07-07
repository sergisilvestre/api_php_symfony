<?php

namespace App\User\Application\DTO;

final readonly class UserDto
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
    ) {
    }
}