FROM php:8.4-apache

# 🔧 FIX 1: Ensure only ONE Apache MPM is enabled
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    nodejs \
    npm \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        intl \
        gd

WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# 🔧 FIX 2: Make Apache listen on Railway PORT
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf \
    /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
