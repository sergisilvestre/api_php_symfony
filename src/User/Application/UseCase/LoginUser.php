<?php

namespace App\User\Application\UseCase;

use App\Auth\Domain\Repository\TokenGenerator;
use App\Shared\Infrastructure\Helpers\TimeHelper;
use App\User\Infrastructure\Doctrine\Entity\UserRecord;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoginUser
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TokenGenerator $auth,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function execute(array $credentials): array
    {
        $email = $credentials['email'] ?? '';

        $this->logger->info(
            'Logging in user with email: ' . $email
        );

        /** @var UserRecord|null $user */
        $user = $this->entityManager
            ->getRepository(UserRecord::class)
            ->findOneBy([
                'email' => $email,
            ]);

        if ($user === null) {
            return [
                'token' => null,
                'ttl' => null,
            ];
        }

        if (!$this->passwordHasher->isPasswordValid(
            $user,
            $credentials['password'] ?? ''
        )) {
            return [
                'token' => null,
                'ttl' => null,
            ];
        }

        $token = $this->auth->generate($user);

        return [
            'token' => $token,
            'ttl' => TimeHelper::addMinutes(
                $this->auth->getTTL()
            ),
        ];
    }
}