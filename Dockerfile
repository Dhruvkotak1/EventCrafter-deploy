FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    libpq-dev libcurl4-openssl-dev libssl-dev libmcrypt-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN chmod -R 777 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=8000
