<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class PostRepository
{
    private const CARD_COLUMNS = 'p.id, p.title, p.slug, p.description, p.image, p.published_at, p.views';
    private const FULL_COLUMNS = 'p.id, p.title, p.slug, p.description, p.image, p.body, p.published_at, p.views';

    /** Разрешённые сортировки (защита от подстановки в ORDER BY). */
    private const SORT_ORDERS = [
        'date' => 'p.published_at DESC, p.id DESC',
        'views' => 'p.views DESC, p.published_at DESC',
    ];

    public function __construct(
        private readonly PDO $db,
    ) {
    }

    /**
     * Последние посты, сгруппированные по id категории (для главной).
     *
     * @param list<int> $categoryIds
     * @return array<int, list<array<string, mixed>>>
     */
    public function getLatestByCategories(array $categoryIds, int $limit): array
    {
        if ($categoryIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

        $stmt = $this->db->prepare(
            'SELECT pc.category_id, ' . self::CARD_COLUMNS . '
             FROM posts p
             INNER JOIN post_categories pc ON pc.post_id = p.id
             WHERE pc.category_id IN (' . $placeholders . ')
             ORDER BY p.published_at DESC, p.id DESC'
        );
        $stmt->execute(array_values($categoryIds));

        $grouped = [];
        foreach ($stmt->fetchAll() as $row) {
            $categoryId = (int) $row['category_id'];

            if (count($grouped[$categoryId] ?? []) < $limit) {
                unset($row['category_id']);
                $grouped[$categoryId][] = $row;
            }
        }

        return $grouped;
    }

    /**
     * Страница постов категории.
     *
     * @return list<array<string, mixed>>
     */
    public function getByCategory(int $categoryId, string $sortBy, int $page, int $perPage): array
    {
        $order = self::SORT_ORDERS[$sortBy] ?? self::SORT_ORDERS['date'];
        $limit = max(1, $perPage);
        $offset = max(0, ($page - 1) * $limit);

        $stmt = $this->db->prepare(
            'SELECT ' . self::CARD_COLUMNS . '
             FROM posts p
             INNER JOIN post_categories pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             ORDER BY ' . $order . '
             LIMIT ' . $limit . ' OFFSET ' . $offset
        );
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*)
             FROM posts p
             INNER JOIN post_categories pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT ' . self::FULL_COLUMNS . ' FROM posts p WHERE p.slug = :slug'
        );
        $stmt->execute(['slug' => $slug]);

        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getCategoriesForPost(int $postId): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.title, c.slug
             FROM categories c
             INNER JOIN post_categories pc ON pc.category_id = c.id
             WHERE pc.post_id = :post_id
             ORDER BY c.title'
        );
        $stmt->execute(['post_id' => $postId]);

        return $stmt->fetchAll();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getSimilar(int $postId, int $limit = 3): array
    {
        $stmt = $this->db->prepare(
            'SELECT DISTINCT ' . self::CARD_COLUMNS . '
             FROM posts p
             INNER JOIN post_categories pc ON pc.post_id = p.id
             WHERE pc.category_id IN (
                 SELECT category_id FROM post_categories WHERE post_id = :post_id
             )
               AND p.id <> :post_id
             ORDER BY p.published_at DESC, p.id DESC
             LIMIT ' . max(1, $limit)
        );
        $stmt->execute(['post_id' => $postId]);

        return $stmt->fetchAll();
    }

    public function incrementViews(int $postId): void
    {
        $stmt = $this->db->prepare('UPDATE posts SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $postId]);
    }
}