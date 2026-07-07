<?php

namespace App\User\Domain\Repository;

use App\Shared\Domain\Contracts\BaseRepositoryInterface;
use App\User\Domain\Entity\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): ?User;
}
