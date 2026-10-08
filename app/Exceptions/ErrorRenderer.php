<?php

declare(strict_types=1);

namespace App\Exceptions;

final class ErrorRenderer
{
    public static function render(int $code, string $message, bool $debug): void
    {
        http_response_code($code);

        $title = $code === 404
            ? 'Страница не найдена'
            : 'Внутренняя ошибка сервера';

        $safeCode = (string) $code;
        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $detail = $debug
            ? '<pre class="error-detail">' . $safeMessage . '</pre>'
            : '';

        echo <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$safeCode} — {$safeTitle}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: -apple-system, system-ui, "Segoe UI", Roboto, Arial, sans-serif; background: #f5f6f8; color: #1f2430; }
        .error-wrap { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .error-card { background: #fff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, .08); padding: 40px; max-width: 560px; text-align: center; }
        .error-code { font-size: 64px; font-weight: 700; margin: 0; line-height: 1; }
        .error-title { font-size: 18px; margin: 12px 0 24px; color: #5a6472; }
        .error-detail { text-align: left; white-space: pre-wrap; word-break: break-word; background: #f0f2f5; border-radius: 8px; padding: 16px; font-size: 13px; color: #333; margin: 0; }
        .error-home { display: inline-block; margin-top: 24px; padding: 10px 20px; background: #2f80ed; color: #fff; text-decoration: none; border-radius: 8px; font-size: 14px; }
        .error-home:hover { background: #1c6fd6; }
    </style>
</head>
<body>
    <div class="error-wrap">
        <div class="error-card">
            <p class="error-code">{$safeCode}</p>
            <p class="error-title">{$safeTitle}</p>
            {$detail}
            <a class="error-home" href="/">На главную</a>
        </div>
    </div>
</body>
</html>
HTML;
    }
}