<?php

namespace App\Auth\Infrastructure;

use App\Auth\Domain\Repository\TokenGenerator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class JwtService implements TokenGenerator
{
    public function __construct(
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function generate(object $user): ?string
    {
        return $this->jwtManager->create($user);
    }

    public function refresh(): string
    {
        throw new \LogicException('JWT refresh is not implemented.');
    }

    public function invalidate(): void
    {
        // JWT is stateless
    }

    public function getTTL(): int
    {
        return 60;
    }
}