<?php

declare(strict_types=1);

namespace App\Controllers;

use Smarty\Exception;
use Smarty\Smarty;

final class HomeController extends Controller
{
    private const POSTS_PER_CATEGORY = 3;

    /**
     * @throws Exception
     */
    public function index(Smarty $smarty): void
    {
        $categories = $this->categoryRepository()->findAll();

        $latest = $this->postRepository()->getLatestByCategories(
            array_map(static fn (array $category): int => (int) $category['id'], $categories),
            self::POSTS_PER_CATEGORY
        );

        $postsByCategory = [];
        foreach ($categories as $category) {
            $postsByCategory[(int) $category['id']] = $latest[(int) $category['id']] ?? [];
        }

        $smarty->assign('title', 'Главная');
        $smarty->assign('categories', $categories);
        $smarty->assign('postsByCategory', $postsByCategory);

        $smarty->display('index.tpl');
    }
}