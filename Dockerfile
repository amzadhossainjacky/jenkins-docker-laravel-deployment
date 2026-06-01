FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html/docker-laravel

# Copy application
COPY . .

# Install dependencies
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html/docker-laravel \
    && chmod -R 755 /var/www/html/docker-laravel

EXPOSE 9000

CMD ["php-fpm"]