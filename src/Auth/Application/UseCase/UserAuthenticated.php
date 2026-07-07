<?php

namespace App\Auth\Application\UseCase;

use App\Auth\Application\Dto\AuthDto;
use App\Auth\Domain\Repository\AuthRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserAuthenticated
{
    public function __construct(
        private AuthRepositoryInterface $repository
    ) {}

    public function execute(): AuthDto
    {
        $auth = $this->repository->getAuthInfo();

        if (!$auth) {
            throw new UnauthorizedHttpException(
                'Bearer',
                'User not authenticated'
            );
        }

        return new AuthDto(
            id: $auth->id,
            email: $auth->email,
            name: $auth->name
        );
    }
}
