# ----------------------------------------------------------
# STAGE 1: Base PHP + extensions
# ----------------------------------------------------------
FROM php:8.4-fpm-alpine AS base

RUN apk add --no-cache \
    nodejs \
    npm \
    chromium \
    nss \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
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

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Puppeteer
RUN npm install -g puppeteer

ENV CHROME_PATH=/usr/bin/chromium-browser

WORKDIR /var/www/html

# ----------------------------------------------------------
# STAGE 2: Vendor
# ----------------------------------------------------------
FROM base AS vendor

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

COPY . .

RUN composer dump-autoload --optimize

# ----------------------------------------------------------
# STAGE 3: Production
# ----------------------------------------------------------
FROM base AS production

WORKDIR /var/www/html

COPY --from=vendor /var/www/html /var/www/html

RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage

RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    && chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]