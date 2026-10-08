<?php

declare(strict_types=1);

namespace App\Routing;

//use App\Controllers\CategoryController;
use App\Controllers\HomeController;
//use App\Controllers\PostController;
use App\Router;

final class Routes
{
    public static function register(Router $router): Router
    {
        $router->add('#^/$#', HomeController::class, 'index');
//        $router->add('#^/category/(?<slug>[A-Za-z0-9_-]+)$#', CategoryController::class, 'show');
//        $router->add('#^/post/(?<slug>[A-Za-z0-9_-]+)$#', PostController::class, 'show');

        return $router;
    }
}