<?php

declare(strict_types=1);

namespace App\config;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    public static function create(array $config): PDO
    {
        $db = $config['db'];

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $db['host'],
            $db['port'],
            $db['dbname'],
            $db['charset']
        );

        try {
            $pdo = new PDO($dsn, $db['username'], $db['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException(
                'Cannot connect to MySQL: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }

        return $pdo;
    }
}