#!/usr/bin/env bash
set -e

echo "🚀 Iniciando Deploy Laravel Blade..."

# Ajusta a porta do Apache para o Render
sed -i "s/80/$PORT/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Otimização do Laravel
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Linking storage..."
php artisan storage:link || true

echo "Running migrations..."
php artisan migrate --force

echo "Starting Apache..."
exec apache2-foreground
