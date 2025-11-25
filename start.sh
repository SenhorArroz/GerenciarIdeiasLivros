#!/usr/bin/env bash
set -e

cd /var/www/html

# Copia .env se não existir
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "Running Composer Install..."
composer install --no-dev --optimize-autoloader

echo "Optimizing application..."
php artisan optimize

# Espera o banco ficar disponível antes de rodar migrations
echo "Waiting for database..."
until php artisan migrate:status >/dev/null 2>&1; do
  sleep 2
done

echo "Running database migrations..."
php artisan migrate --force

# Seeders opcionais (descomente se quiser rodar)
# echo "Running seeders..."
# php artisan db:seed --force

echo "Starting Apache server..."
exec apache2-foreground
