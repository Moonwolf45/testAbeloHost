<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class CategoryRepository
{
    public function __construct(
        private readonly PDO $db,
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function findAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id, title, slug, description
             FROM categories
             ORDER BY title'
        );

        return $stmt->fetchAll();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, title, slug, description
             FROM categories
             WHERE slug = :slug'
        );
        $stmt->execute(['slug' => $slug]);

        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }
}