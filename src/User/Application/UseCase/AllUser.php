<?php

namespace App\User\Application\UseCase;

use Psr\Log\LoggerInterface;
use App\User\Application\DTO\UserDto;
use App\User\Domain\Repository\UserRepositoryInterface;

final readonly class AllUser
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private LoggerInterface $logger,
    ) {}

    /**
     * @return UserDto[]
     */
    public function execute(): array
    {
        $this->logger->info('Fetching all users');

        return array_map(
            static fn($user) => new UserDto(
                id: $user->id(),
                name: $user->name(),
                email: $user->email(),
            ),
            $this->repository->all()
        );
    }
}
