{extends "layout.tpl"}

{block name="content"}
    <nav class="breadcrumbs">
        <a href="/">Главная</a>
        <span class="breadcrumbs__sep">/</span>
        <span class="breadcrumbs__current">{$category.title}</span>
    </nav>

    <header class="category-header">
        <h1 class="page-title">{$category.title}</h1>
        {if $category.description neq ""}
            <p class="category-header__description">{$category.description}</p>
        {/if}
        <p class="muted">Всего статей: {$total}</p>
    </header>

    <div class="sort-controls">
        <span class="sort-controls__label">Сортировка:</span>
        <a class="sort-controls__link{if $sortBy eq "date"} sort-controls__link--active{/if}"
           href="/category/{$category.slug}?sort=date">По дате публикации</a>
        <a class="sort-controls__link{if $sortBy eq "views"} sort-controls__link--active{/if}"
           href="/category/{$category.slug}?sort=views">По числу просмотров</a>
    </div>

    {if $posts|count > 0}
        <div class="posts-list">
            {foreach from=$posts item=post}
                {include file="_post-card.tpl" post=$post}
            {/foreach}
        </div>
    {else}
        <p class="muted">В этой категории пока нет статей.</p>
    {/if}

    {if $pagination.pages > 1}
        <nav class="pagination">
            {if $pagination.prev}
                <a class="pagination__link" href="{$pagination.prev}">&laquo; Назад</a>
            {else}
                <span class="pagination__link pagination__link--disabled">&laquo; Назад</span>
            {/if}

            {foreach from=$pagination.numbers item=num}
                {if $num eq $pagination.page}
                    <span class="pagination__page pagination__page--current">{$num}</span>
                {else}
                    <a class="pagination__page"
                       href="/category/{$category.slug}?sort={$sortBy}&amp;page={$num}">{$num}</a>
                {/if}
            {/foreach}

            {if $pagination.next}
                <a class="pagination__link" href="{$pagination.next}">Вперёд &raquo;</a>
            {else}
                <span class="pagination__link pagination__link--disabled">Вперёд &raquo;</span>
            {/if}
        </nav>
    {/if}
{/block}