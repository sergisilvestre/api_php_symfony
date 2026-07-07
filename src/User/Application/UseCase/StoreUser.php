<?php

namespace App\User\Application\UseCase;

use App\User\Application\DTO\UserDto;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;

final class StoreUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function execute(array $data): UserDto
    {
        $user = new User(
            id: null,
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );

        $this->userRepository->save($user);

        return new UserDto(
            id: $user->id(),
            name: $user->name(),
            email: $user->email(),
        );
    }
}
