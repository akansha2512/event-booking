# Use official PHP image
FROM php:8.1-cli

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd mbstring

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Debug: force composer to show full output
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

# Generate Laravel key (if .env present)
RUN php artisan key:generate || echo "key:generate skipped"

# Expose port and run app
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
