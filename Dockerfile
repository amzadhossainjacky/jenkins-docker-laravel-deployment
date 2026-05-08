FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mysqli zip

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Laravel project path
WORKDIR /var/www/html/docker-laravel

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set Apache document root to Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/docker-laravel/public|g' /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html/docker-laravel \
    && chmod -R 755 /var/www/html/docker-laravel

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]