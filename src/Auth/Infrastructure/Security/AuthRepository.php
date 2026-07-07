<?php

namespace App\Auth\Infrastructure\Security;

use App\Auth\Application\Dto\AuthDto;
use App\Auth\Domain\Repository\AuthRepositoryInterface;
// use App\User\Domain\Entity\User;
use App\User\Infrastructure\Doctrine\Entity\UserRecord as User;
use Symfony\Bundle\SecurityBundle\Security;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    private function user(): ?User
    {
        $user = $this->security->getUser();

        return $user instanceof User ? $user : null;
    }

    public function id(): ?int
    {
        return $this->user()?->id();
    }

    public function email(): ?string
    {
        return $this->user()?->email();
    }

    public function name(): ?string
    {
        return $this->user()?->name();
    }

    public function getAuthInfo(): AuthDto
    {
        $user = $this->user();

        if ($user === null) {
            throw new \RuntimeException('No authenticated user.');
        }

        return new AuthDto(
            id: $user->id(),
            email: $user->email(),
            name: $user->name(),
        );
    }
}