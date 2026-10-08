<?php

declare(strict_types=1);

namespace App;

final class Router
{
    /**
     * @var array<int, array{regex: string, controller: class-string, action: string}>
     */
    private array $routes = [];

    public function add(string $regex, string $controller, string $action): void
    {
        $this->routes[] = [
            'regex' => $regex,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    /**
     * @return array{0: class-string, 1: string, 2: array<string, string>}|null
     */
    public function dispatch(string $path): ?array
    {
        foreach ($this->routes as $route) {
            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter(
                    $matches,
                    static fn (string|int $key, string $value): bool => is_string($key),
                    ARRAY_FILTER_USE_BOTH
                );

                return [$route['controller'], $route['action'], $params];
            }
        }

        return null;
    }
}