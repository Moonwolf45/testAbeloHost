<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title|default:"Блог"} — Простой блог</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="site-brand" href="/">Простой блог</a>
        <nav class="site-nav">
            <a href="/">Главная</a>
        </nav>
    </div>
</header>

<main class="container main-content">
    {block name="content"}{/block}
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; {$smarty.now|date_format:"%Y"} Простой блог. Чистый PHP + Smarty + MySQL.</p>
    </div>
</footer>
</body>
</html>