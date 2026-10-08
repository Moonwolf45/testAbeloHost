<?php

declare(strict_types=1);

namespace App;

use App\config\Database;
use App\config\SmartyFactory;
use App\Exceptions\ErrorRenderer;
use App\Exceptions\NotFoundException;
use App\Routing\Routes;
use Smarty\Exception;
use Smarty\Smarty;
use Throwable;

final class Application
{
    public function run(): void
    {
        $config = [];
        $smarty = null;

        try {
            $config = Config::load();

            $db = Database::create($config);
            $smarty = SmartyFactory::create($config, (bool) $config['debug']);

            $route = Routes::register(new Router())->dispatch($this->requestPath());

            if ($route === null) {
                throw new NotFoundException('Страница не найдена.');
            }

            [$controllerClass, $action, $params] = $route;

            $controller = new $controllerClass($db, $config);
            $controller->{$action}($smarty, ...$params);
        } catch (NotFoundException $e) {
            $this->renderNotFound($smarty, $e);
        } catch (Throwable $e) {
            $this->renderError($config, $e);
        }
    }

    /**
     * Путь запроса без query string (для передачи в Router).
     */
    private function requestPath(): string
    {
        $path = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?? '/');
        $path = urldecode($path);

        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    /**
     * @throws Exception
     */
    private function renderNotFound(?Smarty $smarty, NotFoundException $e): void
    {
        http_response_code(404);

        if ($smarty !== null) {
            $smarty->display('error-404.tpl');

            return;
        }

        // Smarty ещё не создан (ошибка на этапе загрузки конфига).
        ErrorRenderer::render(404, $e->getMessage(), false);
    }

    private function renderError(array $config, Throwable $e): void
    {
        error_log(sprintf(
            'Application error: %s in %s:%d',
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        ));

        ErrorRenderer::render(500, $e->getMessage(), (bool) ($config['debug'] ?? false));
    }
}