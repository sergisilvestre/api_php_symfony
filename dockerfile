FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libsodium-dev \
    libssl-dev \
    openssl \
    zlib1g-dev \
    unzip \
    git \
    pkg-config \
    netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    intl \
    bcmath \
    zip \
    xml \
    sodium

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN composer install \
    --prefer-dist \
    --no-interaction \
    --no-scripts \
    --dev

COPY . .

RUN composer dump-autoload -o

RUN mkdir -p var/cache var/log config/jwt \
 && chown -R www-data:www-data var config/jwt \
 && chmod -R 775 var config/jwt

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

CMD ["/entrypoint.sh"]