<?php

namespace App\Shared\Domain\Contracts;

interface BaseRepositoryInterface
{
    /**
     * @return object[]
     */
    public function all(): array;

    /**
     * @return object[]
     */
    public function paginate(int $page = 1, int $perPage = 15): array;

    public function find(int $id): ?object;

    public function save(object $entity): void;

    public function delete(object $entity): void;
}