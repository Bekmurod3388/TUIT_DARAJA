FROM php:8.3-fpm

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
CMD ["/usr/local/bin/entrypoint.sh"]
