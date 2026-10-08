{extends "layout.tpl"}

{block name="content"}
    <nav class="breadcrumbs">
        <a href="/">Главная</a>
        <span class="breadcrumbs__sep">/</span>
        {if $categories|count > 0}
            <a href="/category/{$categories[0].slug}">{$categories[0].title}</a>
            <span class="breadcrumbs__sep">/</span>
        {/if}
        <span class="breadcrumbs__current">{$post.title}</span>
    </nav>

    <article class="post">
        <header class="post__header">
            <h1 class="post__title">{$post.title}</h1>
            <p class="post__description">{$post.description}</p>
            <div class="post__meta">
                <span class="post__date">Опубликовано: {$post.published_at|date_format:"%d.%m.%Y %H:%M"}</span>
                <span class="post__views">{$post.views} просмотров</span>
            </div>
            {if $categories|count > 0}
                <div class="post__categories">
                    {foreach from=$categories item=category}
                        <a class="tag" href="/category/{$category.slug}">{$category.title}</a>
                    {/foreach}
                </div>
            {/if}
        </header>

        <img class="post__image" src="{$post.image}" alt="{$post.title}">

        <div class="post__body">
            {$post.body}
        </div>
    </article>

    {if $similar|count > 0}
        <section class="similar">
            <h2 class="similar__title">Похожие статьи</h2>
            <div class="posts-grid">
                {foreach from=$similar item=post}
                    {include file="_post-card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}