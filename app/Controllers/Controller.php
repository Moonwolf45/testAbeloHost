<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use PDO;

abstract class Controller
{
    protected PDO $db;
    protected array $config;

    public function __construct(
        PDO $db,
        array $config
    ) {
        $this->db = $db;
        $this->config = $config;
    }

    protected function categoryRepository(): CategoryRepository
    {
        return new CategoryRepository($this->db);
    }

    protected function postRepository(): PostRepository
    {
        return new PostRepository($this->db);
    }
}