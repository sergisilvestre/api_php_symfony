FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    zlib1g-dev \
    unzip \
    git \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    intl \
    bcmath \
    zip \
    xml

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-scripts

COPY . .

RUN composer dump-autoload -o

RUN mkdir -p var/cache var/log \
 && chown -R www-data:www-data var \
 && chmod -R 775 var

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8000

CMD ["/entrypoint.sh"]