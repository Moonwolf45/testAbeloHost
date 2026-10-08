<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use Smarty\Smarty;

final class CategoryController extends Controller
{
    private const SORT_OPTIONS = ['date', 'views'];

    public function show(Smarty $smarty, string $slug): void
    {
        $category = $this->categoryRepository()->findBySlug($slug);

        if ($category === null) {
            throw new NotFoundException('Категория не найдена.');
        }

        $sortBy = $_GET['sort'] ?? 'date';
        if (!in_array($sortBy, self::SORT_OPTIONS, true)) {
            $sortBy = 'date';
        }

        $perPage = max(1, (int) ($this->config['pagination']['posts_per_page'] ?? 6));
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $total = $this->postRepository()->countByCategory((int) $category['id']);
        $pages = max(1, (int) ceil($total / $perPage));

        if ($page > $pages) {
            $page = $pages;
        }

        $posts = $this->postRepository()->getByCategory(
            (int) $category['id'],
            $sortBy,
            $page,
            $perPage
        );

        $smarty->assign('title', $category['title']);
        $smarty->assign('category', $category);
        $smarty->assign('posts', $posts);
        $smarty->assign('total', $total);
        $smarty->assign('sortBy', $sortBy);
        $smarty->assign('pagination', $this->makePagination($slug, $sortBy, $page, $pages));

        $smarty->display('category.tpl');
    }

    /**
     * Данные для пагинации. prev/next — готовые href (шаблон подставляет их как есть),
     * пустая строка → disabled-вариант в category.tpl.
     */
    private function makePagination(string $slug, string $sortBy, int $page, int $pages): array
    {
        return [
            'page' => $page,
            'pages' => $pages,
            'prev' => $page > 1 ? $this->pageUrl($slug, $sortBy, $page - 1) : '',
            'next' => $page < $pages ? $this->pageUrl($slug, $sortBy, $page + 1) : '',
            'numbers' => $pages > 0 ? range(1, $pages) : [],
        ];
    }

    private function pageUrl(string $slug, string $sortBy, int $page): string
    {
        return sprintf('/category/%s?sort=%s&page=%d', $slug, $sortBy, $page);
    }

}