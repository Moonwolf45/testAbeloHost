<?php

declare(strict_types=1);

use App\config\Database;

require __DIR__ . '/../../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

$schemaPath = __DIR__ . '/schema.sql';

if (!is_file($schemaPath) || !is_readable($schemaPath)) {
    fwrite(STDERR, 'Migration failed: schema file not found: ' . $schemaPath . PHP_EOL);

    exit(1);
}

try {
    $pdo = Database::create($config);

    $sql = (string)file_get_contents($schemaPath);

    // Разбиваем скрипт на отдельные инструкции по символу ";".
    // PDO::exec() не выполняет несколько инструкций за один вызов,
    // поэтому применяем их по одной. Схема состоит только из
    // CREATE TABLE IF NOT EXISTS, поэтому разбивка по ";" безопасна.
    $statements = array_values(
        array_filter(
            array_map('trim', explode(';', $sql)),
            static fn(string $statement): bool => $statement !== ''
        )
    );

    foreach ($statements as $statement) {
        $pdo->exec($statement);
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Migration failed: ' . $e->getMessage() . PHP_EOL);

    exit(1);
}

echo 'Migration OK (' . count($statements) . " statements)\n";