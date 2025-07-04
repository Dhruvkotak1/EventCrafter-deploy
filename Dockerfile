FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl \
    libzip-dev libpq-dev mariadb-client

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy .env example as .env
RUN cp .env.example .env

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader



# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install JS dependencies & build assets
RUN npm ci
RUN npm run build

# Install Node.js and Vite dependencies
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

RUN npm install && npm run build

# Copy .env file
RUN cp .env.example .env

# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 775 storage bootstrap/cache

# Run Laravel setup
CMD php artisan config:clear && \
    php artisan key:generate --force && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=$PORT
