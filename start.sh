#!/usr/bin/env bash
set -e

cd /var/www/html

# Cria .env se não existir
if [ ! -f .env ]; then
    echo "Creating .env..."
    cp .env.example .env
fi

# Permissões
chown -R www-data:www-data storage bootstrap/cache

echo "Installing Composer..."
composer install --no-dev --optimize-autoloader

# Gera chave se estiver vazia
if ! grep -q "^APP_KEY=" .env || [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "Caching Laravel..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Creating storage link..."
php artisan storage:link || true

echo "Running migrations..."
php artisan migrate --force

# Configura Apache para usar a porta do Render
echo "Configuring Apache on PORT $PORT..."
sed -i "s/80/$PORT/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

echo "Starting Apache..."
exec apache2-foreground
