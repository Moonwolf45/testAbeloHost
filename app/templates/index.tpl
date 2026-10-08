{extend "layout.tpl"}

{block name="content"}
    <h1 class="page-title">Блог</h1>

    {if $categories|count > 0}
        {foreach from=$categories item=category}
            <section class="category-section">
                <div class="category-section__head">
                    <div>
                        <h2 class="category-section__title">
                            <a href="/category/{$category.slug}">{$category.title}</a>
                        </h2>
                        {if $category.description neq ""}
                            <p class="category-section__description">{$category.description}</p>
                        {/if}
                    </div>
                    <a class="btn btn--primary" href="/category/{$category.slug}">Все статьи</a>
                </div>

                <div class="posts-grid">
                    {assign var="categoryPosts" value=$postsByCategory[$category.id]|default:[]}
                    {if $categoryPosts|count > 0}
                        {foreach from=$categoryPosts item=post}
                            {include file="_post-card.tpl" post=$post}
                        {/foreach}
                    {else}
                        <p class="muted">В этой категории пока нет статей.</p>
                    {/if}
                </div>
            </section>
        {/foreach}
    {else}
        <p class="muted">Категорий пока нет. Запустите сидинг: <code>make exec-app CMD="php app/bin/seed.php"</code></p>
    {/if}
{/block}