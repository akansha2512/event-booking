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
# Install dependencies (show logs if fails)
RUN composer install || (echo "Composer failed" && cat composer.json && exit 1)

# Copy env and generate key (only after vendor is created)
RUN cp .env.example .env && ls -la vendor && php artisan key:generate || (echo "Key generate failed" && exit 1)


# Set permissions (optional for some setups)
RUN chown -R www-data:www-data /var/www

# Generate application key
RUN cp .env.example .env && php artisan key:generate

# Expose port and run Laravel app
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
