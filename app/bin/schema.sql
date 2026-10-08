CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE,
    description VARCHAR(500) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    description VARCHAR(500) NOT NULL,
    image VARCHAR(500) NOT NULL,
    body TEXT NOT NULL,
    published_at DATETIME NOT NULL,
    views INT UNSIGNED NOT NULL DEFAULT 0,
    INDEX idx_posts_published_at (published_at),
    INDEX idx_posts_views (views),
    INDEX idx_posts_slug (slug)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS post_categories (
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (post_id, category_id),
    CONSTRAINT fk_post_categories_post
    FOREIGN KEY (post_id)
    REFERENCES posts (id)
    ON DELETE CASCADE,
    CONSTRAINT fk_post_categories_category
    FOREIGN KEY (category_id)
    REFERENCES categories (id)
    ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;