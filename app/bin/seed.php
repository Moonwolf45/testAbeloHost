<?php

declare(strict_types=1);

use App\config\Database;

require __DIR__ . '/../../vendor/autoload.php';

$config = require __DIR__ . '/../config/config.php';

$pdo = Database::create($config);

$categories = [
    [
        'title' => 'PHP',
        'slug' => 'php',
        'description' => 'Статьи про PHP, чистый PHP и архитектурные решения.',
    ],
    [
        'title' => 'Docker',
        'slug' => 'docker',
        'description' => 'Docker, контейнеры, локальная разработка.',
    ],
    [
        'title' => 'Базы данных',
        'slug' => 'databases',
        'description' => 'MySQL, SQL, проектирование и оптимизация.',
    ],
    [
        'title' => 'Веб-разработка',
        'slug' => 'web',
        'description' => 'Фронтенд, стили, структура проектов и best practices.',
    ],
];

$posts = [
    [
        'title' => 'PHP 8.1: что нового',
        'slug' => 'php-8-1-what-is-new',
        'description' => 'Коротко о важных изменениях в PHP 8.1.',
        'image' => 'https://picsum.photos/seed/php-8-1/800/420',
        'body' => '<p>PHP 8.1 добавил несколько удобных возможностей, которые делают код чище и проще.</p><p>Среди них: readonly-свойства, улучшение enum, новые методы работы с массивами и более строгие проверки.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 5 * 86400),
        'views' => 120,
        'categories' => ['php', 'web'],
    ],
    [
        'title' => 'Чистый PHP без фреймворков',
        'slug' => 'plain-php-without-framework',
        'description' => 'Почему чистый PHP может быть простым и понятным.',
        'image' => 'https://picsum.photos/seed/plain-php/800/420',
        'body' => '<p>Фреймворк не обязателен для хорошего проекта. Чистый PHP можно структурировать так, чтобы код оставался читаемым.</p><p>Главное — разделить ответственность: репозитории, контроллеры, шаблоны и конфиг.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 4 * 86400),
        'views' => 95,
        'categories' => ['php'],
    ],
    [
        'title' => 'Docker для локальной разработки',
        'slug' => 'docker-for-local-development',
        'description' => 'Как упростить запуск PHP + MySQL + Nginx.',
        'image' => 'https://picsum.photos/seed/docker-local/800/420',
        'body' => '<p>Docker позволяет быстро поднять нужное окружение без ручной установки PHP, MySQL и Nginx.</p><p>С docker compose можно описать весь стек в одном файле.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 3 * 86400),
        'views' => 210,
        'categories' => ['docker', 'web'],
    ],
    [
        'title' => 'MySQL и индексы',
        'slug' => 'mysql-and-indexes',
        'description' => 'Почему индексы важны для производительности.',
        'image' => 'https://picsum.photos/seed/mysql-indexes/800/420',
        'body' => '<p>Индексы ускоряют выборку данных, но требуют внимательности.</p><p>Стоит индексировать поля, которые часто используются в WHERE, ORDER BY и JOIN.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 3 * 86400),
        'views' => 180,
        'categories' => ['databases'],
    ],
    [
        'title' => 'Smarty: шаблоны просто',
        'slug' => 'smarty-templates-simple',
        'description' => 'Базовый подход к Smarty без лишней магии.',
        'image' => 'https://picsum.photos/seed/smarty-simple/800/420',
        'body' => '<p>Smarty удобно использовать как простой шаблонизатор.</p><p>Важно не переносить в шаблоны сложную бизнес-логику, а держать там только вывод данных.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 2 * 86400),
        'views' => 75,
        'categories' => ['php', 'web'],
    ],
    [
        'title' => 'Пагинация в PHP',
        'slug' => 'pagination-in-php',
        'description' => 'Как правильно делать пагинацию.',
        'image' => 'https://picsum.photos/seed/pagination-php/800/420',
        'body' => '<p>Пагинация помогает не выгружать все данные сразу.</p><p>Для простого блога достаточно LIMIT и OFFSET с контролем номера страницы.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 2 * 86400),
        'views' => 60,
        'categories' => ['php', 'databases'],
    ],
    [
        'title' => 'Nginx + PHP-FPM',
        'slug' => 'nginx-php-fpm',
        'description' => 'Классическая связка для PHP-приложений.',
        'image' => 'https://picsum.photos/seed/nginx-fpm/800/420',
        'body' => '<p>Nginx хорошо подходит для раздачи статики и передачи PHP-запросов в PHP-FPM.</p><p>Это простая и надёжная связка для небольших проектов.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 1 * 86400),
        'views' => 140,
        'categories' => ['docker', 'web'],
    ],
    [
        'title' => 'PDO: безопасность запросов',
        'slug' => 'pdo-safe-queries',
        'description' => 'Как писать SQL без SQL-инъекций.',
        'image' => 'https://picsum.photos/seed/pdo-safe/800/420',
        'body' => '<p>PDO с prepared statements — базовый способ защиты от SQL-инъекций.</p><p>Никогда не подставлявайте пользовательский ввод прямо в SQL.</p>',
        'published_at' => date('Y-m-d H:i:s', time() - 1 * 86400),
        'views' => 300,
        'categories' => ['php', 'databases'],
    ],
    [
        'title' => 'SCSS в небольших проектах',
        'slug' => 'scss-in-small-projects',
        'description' => 'Когда SCSS полезен, а когда достаточно plain CSS.',
        'image' => 'https://picsum.photos/seed/scss-small/800/420',
        'body' => '<p>SCSS удобен, когда стилей становится больше, а переменных и миксинов появляется.</p><p>Для маленького проекта можно использовать и обычный CSS.</p>',
        'published_at' => date('Y-m-d H:i:s', time()),
        'views' => 45,
        'categories' => ['web'],
    ],
    [
        'title' => 'Категории в блоге',
        'slug' => 'blog-categories',
        'description' => 'Как устроена связь постов и категорий.',
        'image' => 'https://picsum.photos/seed/blog-categories/800/420',
        'body' => '<p>Для блога часто нужна связь многие ко многим: у поста может быть несколько категорий.</p><p>Для этого используется промежуточная таблица post_categories.</p>',
        'published_at' => date('Y-m-d H:i:s', time()),
        'views' => 30,
        'categories' => ['databases', 'web'],
    ],
];

$pdo->exec(
    "SET FOREIGN_KEY_CHECKS = 0;
     TRUNCATE TABLE categories;
     TRUNCATE TABLE post_categories;
     TRUNCATE TABLE posts;
     SET FOREIGN_KEY_CHECKS = 1;"
);

try {
    $pdo->beginTransaction();

    $categoryStmt = $pdo->prepare(
        'INSERT INTO categories (title, slug, description)
         VALUES (:title, :slug, :description)'
    );

    $categoryIds = [];

    foreach ($categories as $category) {
        $categoryStmt->execute([
            'title' => $category['title'],
            'slug' => $category['slug'],
            'description' => $category['description'],
        ]);

        $categoryIds[$category['slug']] = (int) $pdo->lastInsertId();
    }

    $postStmt = $pdo->prepare(
        'INSERT INTO posts (title, slug, description, image, body, published_at, views)
         VALUES (:title, :slug, :description, :image, :body, :published_at, :views)'
    );

    $linkStmt = $pdo->prepare(
        'INSERT INTO post_categories (post_id, category_id)
         VALUES (:post_id, :category_id)'
    );

    foreach ($posts as $post) {
        $postStmt->execute([
            'title' => $post['title'],
            'slug' => $post['slug'],
            'description' => $post['description'],
            'image' => $post['image'],
            'body' => $post['body'],
            'published_at' => $post['published_at'],
            'views' => $post['views'],
        ]);

        $postId = (int) $pdo->lastInsertId();

        foreach ($post['categories'] as $categorySlug) {
            $linkStmt->execute([
                'post_id' => $postId,
                'category_id' => $categoryIds[$categorySlug],
            ]);
        }
    }

    $pdo->commit();

    echo "Seed OK\n";
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Seed failed: ' . $e->getMessage() . PHP_EOL;

    exit(1);
}