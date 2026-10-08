<?php

declare(strict_types=1);

use App\Application;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: text/html; charset=utf-8');

(new Application())->run();