#!/usr/bin/env bash
set -e

cd "$(dirname "$0")"

echo "==> Pulling latest changes..."
git pull

echo "==> Installing Composer dependencies..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

echo "==> Installing NPM dependencies..."
npm install

echo "==> Building frontend assets..."
npm run build

echo "==> Clearing Laravel caches..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

echo "==> Done! Deployment complete."
