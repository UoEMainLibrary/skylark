#!/usr/bin/env bash
set -e

cd "$(dirname "$0")"

echo "==> Pulling latest changes..."
git pull

echo "==> Installing Composer dependencies..."
# --no-dev omits require-dev only; production packages (e.g. filament/filament in require) are still installed.
# Filament → openspout requires PHP ext-zip (install the zip package matching your PHP version, then restart PHP-FPM/web).
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

if [ ! -f vendor/filament/filament/src/PanelProvider.php ]; then
    echo "ERROR: Filament is not present under vendor/ after composer install."
    echo "Check that composer.lock is deployed and composer install completed without errors."
    exit 1
fi

echo "==> Running database migrations..."
php artisan migrate --force --no-interaction

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
