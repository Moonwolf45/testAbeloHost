<?php

declare(strict_types=1);

namespace App;

final class Config
{
    public static function load(): array
    {
        return require dirname(__DIR__) . '/app/config/config.php';
    }
}