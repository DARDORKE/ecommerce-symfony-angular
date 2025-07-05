#!/bin/bash

# Build script for Railway
set -e

echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "Clearing cache..."
php bin/console cache:clear --env=prod

echo "Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Build complete!"