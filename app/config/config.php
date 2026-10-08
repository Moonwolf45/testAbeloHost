<?php

declare(strict_types=1);

return [
    'env' => getenv('APP_ENV') ?: 'local',
    'debug' => filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOLEAN),

    'db' => [
        'host' => getenv('DB_HOST') ?: 'db',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'dbname' => getenv('DB_NAME') ?: 'app',
        'username' => getenv('DB_USER') ?: 'app',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],

    'pagination' => [
        'posts_per_page' => 6,
    ],

    'smarty' => [
        'template_dir' => dirname(__DIR__) . '/templates',
        'compile_dir' => dirname(__DIR__, 2) . '/smarty/templates_c',
        'cache_dir' => dirname(__DIR__, 2) . '/smarty/cache',
    ],
];