# Use official PHP image with extensions
FROM php:8.1-cli

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Copy app code
COPY . .

# Show errors if composer fails
RUN composer install || cat /root/.composer/cache/logs/*.log

# Generate app key
RUN php artisan key:generate || true

# Expose port and run Laravel
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
