# syntax=docker/dockerfile:1

FROM composer:2 AS vendor
ENV COMPOSER_ALLOW_SUPERUSER=1
WORKDIR /var/www/html

COPY composer.json ./
COPY app ./app

# Если у вас есть composer.lock, раскомментируйте строку ниже для стабильной сборки:
# COPY composer.lock ./

RUN composer install --no-dev --no-interaction --no-progress --no-audit --no-scripts

FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev \
    && docker-php-ext-install pdo_mysql opcache zip \
    && docker-php-ext-enable mbstring \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=vendor /var/www/html/vendor /var/www/html/vendor
COPY app /var/www/html/app
COPY php/php.ini /usr/local/etc/php/conf.d/app.ini

RUN chown -R www-data:www-data /var/www/html/app/cache \
    && chmod -R 775 /var/www/html/app/cache

EXPOSE 9000

CMD ["php-fpm"]