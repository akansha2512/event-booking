FROM php:8.1-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y unzip git curl libzip-dev zip && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install project dependencies
RUN composer install

# Generate app key
RUN php artisan key:generate

# Expose port and run
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
