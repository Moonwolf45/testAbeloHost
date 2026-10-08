<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use Smarty\Smarty;

final class PostController extends Controller
{
    private const SIMILAR_LIMIT = 3;

    public function show(Smarty $smarty, string $slug): void
    {
        $post = $this->postRepository()->findBySlug($slug);

        if ($post === null) {
            throw new NotFoundException('Статья не найдена.');
        }

        $postId = (int) $post['id'];

        $this->postRepository()->incrementViews($postId);

        $smarty->assign('title', $post['title']);
        $smarty->assign('post', $post);
        $smarty->assign('categories', $this->postRepository()->getCategoriesForPost($postId));
        $smarty->assign('similar', $this->postRepository()->getSimilar($postId, self::SIMILAR_LIMIT));

        $smarty->display('post.tpl');
    }
}