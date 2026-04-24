# ----------------------------------------------------------
# STAGE 1: Base PHP + extensions
# ----------------------------------------------------------
FROM php:8.4-fpm-alpine AS base

RUN apk add --no-cache \
    autoconf \
    g++ \
    make \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    postgresql-libs \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        libxml2-dev \
        libzip-dev \
        postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        mbstring \
        zip \
        gd \
        opcache \
        pcntl \
    && apk del .build-deps

WORKDIR /var/www/html

# ----------------------------------------------------------
# STAGE 2: Composer
# ----------------------------------------------------------
FROM composer:2 AS vendor

WORKDIR /var/www/html

# Copiar solo archivos necesarios primero (mejor cache)
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# Ahora copiar el resto del proyecto
COPY . .

RUN composer dump-autoload --optimize

# ----------------------------------------------------------
# STAGE 3: Final Production Image
# ----------------------------------------------------------
FROM base AS production

WORKDIR /var/www/html

COPY --from=vendor /var/www/html /var/www/html

# Crear symlink manual
RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
