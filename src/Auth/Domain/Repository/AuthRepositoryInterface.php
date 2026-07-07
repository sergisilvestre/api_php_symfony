<?php

namespace App\Auth\Domain\Repository;

use App\Auth\Application\Dto\AuthDto;

interface AuthRepositoryInterface
{
    public function getAuthInfo(): AuthDto;

    public function id(): ?int;

    public function email(): ?string;

    public function name(): ?string;
}
