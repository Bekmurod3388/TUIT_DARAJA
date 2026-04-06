FROM php:8.3-fpm AS base

# System packages for PHP extensions (Debian, php:8.3-fpm)
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libicu-dev \
    libsqlite3-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zlib1g-dev \
    unzip \
    git \
    curl \
    ca-certificates \
    vim \
 && docker-php-source extract \
 && cp /usr/src/php/ext/sqlite3/config0.m4 /usr/src/php/ext/sqlite3/config.m4 \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" \
      pdo_mysql mbstring zip exif pcntl intl gd \
 && docker-php-ext-install -j"$(nproc)" pdo_sqlite \
 && docker-php-ext-install -j"$(nproc)" sqlite3 \
 && docker-php-ext-enable opcache \
 && docker-php-source delete \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Opcache
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/TUIT_DARAJA

# Entrypoint
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && sed -i 's/\r$//' /usr/local/bin/entrypoint.sh

EXPOSE 9000

FROM base AS development
CMD ["/usr/local/bin/entrypoint.sh"]

FROM base AS production

COPY . /var/www/TUIT_DARAJA
COPY docker/php/opcache.prod.ini /usr/local/etc/php/conf.d/zz-opcache-production.ini

RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
        --classmap-authoritative \
        --no-scripts \
    && mkdir -p \
        storage/app/private \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data storage bootstrap/cache

CMD ["/usr/local/bin/entrypoint.sh"]
