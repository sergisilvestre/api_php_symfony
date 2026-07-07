<?php

namespace App\Auth\Application\DTO;

final readonly class AuthDto
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
    ) {
    }
}