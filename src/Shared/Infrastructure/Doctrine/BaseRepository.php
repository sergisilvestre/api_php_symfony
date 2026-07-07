<?php

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class BaseRepository
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EntityRepository $repository,
    ) {
    }

    public function all(): array
    {
        return $this->repository->findAll();
    }

    public function find(int $id): ?object
    {
        return $this->repository->find($id);
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}