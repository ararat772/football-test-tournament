FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    zip \
    unzip

# Install extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

WORKDIR /var/www/symfony

COPY . .
