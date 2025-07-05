FROM php:8.2-cli

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
RUN composer update phpstan/phpdoc-parser --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Generate autoload files
RUN composer dump-autoload --optimize

# Create necessary directories and set permissions
RUN mkdir -p /app/var/cache /app/var/log /app/var/sessions
RUN chmod -R 775 /app/var

# Expose the port
EXPOSE $PORT

# Start PHP development server
CMD php -S 0.0.0.0:${PORT:-8080} -t public