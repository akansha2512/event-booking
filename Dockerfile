# Use PHP 8.1 base image
FROM php:8.1

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Copy all project files
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || cat composer.json && ls -la vendor || true


# Set permissions (optional for some setups)
RUN chown -R www-data:www-data /var/www

# Generate application key
RUN cp .env.example .env && php artisan key:generate

# Expose port and run Laravel app
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
