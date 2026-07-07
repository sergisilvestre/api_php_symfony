<?php

namespace App\Shared\Infrastructure\Helpers;

final class TimeHelper
{
    public static function addMinutes(int $minutes): \DateTimeImmutable
    {
        return (new \DateTimeImmutable())
            ->modify("+{$minutes} minutes");
    }

    public static function now(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}