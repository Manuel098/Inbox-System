FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader

RUN php artisan migrate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

CMD ["php-fpm"]