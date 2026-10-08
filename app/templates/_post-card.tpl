<article class="post-card">
    <a class="post-card__image" href="/post/{$post.slug}">
        <img src="{$post.image}" alt="{$post.title}" loading="lazy">
    </a>
    <div class="post-card__body">
        <h3 class="post-card__title">
            <a href="/post/{$post.slug}">{$post.title}</a>
        </h3>
        <p class="post-card__description">{$post.description}</p>
        <div class="post-card__meta">
            <span class="post-card__date">{$post.published_at|date_format:"%d.%m.%Y"}</span>
            <span class="post-card__views">{$post.views} просмотров</span>
        </div>
    </div>
</article>