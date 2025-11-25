#!/usr/bin/env bash
set -e

cd /var/www/html

# Copia .env se não existir
if [ ! -f .env ]; then
    echo "Creating .env file..."
    cp .env.example .env
fi

# Ajuste de permissões (crítico para evitar erro de log/cache)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "Running Composer Install..."
composer install --no-dev --optimize-autoloader

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Espera o banco ficar disponível
echo "Waiting for database..."
# Nota: Removi o migrate:status aqui pois as vezes falha na primeira conexão
# Se o DB estiver no mesmo render.yaml, ele deve estar acessível logo
php artisan key:generate --force
php artisan storage:link
echo "Running database migrations..."
php artisan db:fresh


# Configura Apache para escutar na porta correta do Render
echo "Configuring Apache on port ${PORT}..."
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

echo "Starting Apache..."
exec apache2-foreground
