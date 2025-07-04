FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json ./
COPY composer.lock* ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Create necessary directories and set permissions
RUN mkdir -p /app/var/cache /app/var/log /app/var/sessions
RUN chown -R www-data:www-data /app/var /app/public
RUN chmod -R 775 /app/var

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]