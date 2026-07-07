<?php

namespace App\Auth\Application\UseCase;

use App\Auth\Application\Dto\AuthDto;
use App\Auth\Domain\Repository\AuthRepositoryInterface;

class UserAuthenticated
{
    public function __construct(private AuthRepositoryInterface $repository) {}

    public function execute(): AuthDto
    {
        $auth = $this->repository->getAuthInfo();
        return new AuthDto(
            id: $auth->id,
            email: $auth->email,
            name: $auth->name
        );
    }
}
