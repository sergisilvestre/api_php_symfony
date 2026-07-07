<?php

namespace App\Shared\Infrastructure\Helpers;

use Psr\Log\LoggerInterface;

final class LogHelper
{
    private static ?LoggerInterface $logger = null;

    public static function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    public static function write(string $channel, string $message): void
    {
        if (self::$logger === null) {
            throw new \RuntimeException('Logger not initialized.');
        }

        self::$logger->info($message, [
            'channel' => $channel,
        ]);
    }
}