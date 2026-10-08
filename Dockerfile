# syntax=docker/dockerfile:1

FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql opcache zip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --no-progress

COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

RUN chown -R www-data:www-data smarty \
    && chmod -R 775 smarty

EXPOSE 9000

CMD ["php-fpm"]