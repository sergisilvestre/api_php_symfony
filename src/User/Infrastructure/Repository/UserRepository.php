<?php
namespace App\User\Infrastructure\Repository;

use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepositoryInterface;
use App\User\Infrastructure\Doctrine\Entity\UserRecord;
use App\User\Infrastructure\Doctrine\Mapper\UserMapper;
use Doctrine\ORM\EntityManagerInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function all(): array
    {
        return $this->entityManager
            ->getRepository(UserRecord::class)
            ->findAll();
    }

    public function paginate(int $page = 1, int $perPage = 15): array
    {
        return $this->entityManager
            ->getRepository(UserRecord::class)
            ->createQueryBuilder('u')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?object
    {
        return $this->entityManager
            ->getRepository(UserRecord::class)
            ->find($id);
    }

    public function save(object $entity): void
    {
        if (!$entity instanceof User) {
            throw new \InvalidArgumentException(
                'UserRepository expects User entity'
            );
        }

        $record = UserMapper::toRecord($entity);

        $this->entityManager->persist($record);
        $this->entityManager->flush();
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}