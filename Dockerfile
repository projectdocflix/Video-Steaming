FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev libzip-dev zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip bcmath exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader
