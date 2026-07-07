<?php

namespace App\Auth\Domain\Repository;

interface TokenGenerator
{
    public function generate(object $user): ?string;
    
    public function refresh(): string;
    
    public function invalidate(): void;

    public function getTTL(): int;
}
