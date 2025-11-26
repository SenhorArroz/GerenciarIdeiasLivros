FROM php:8.2-apache

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dependências
RUN apt-get update && apt-get install -y \
    libpq-dev git zip unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Ativa mod_rewrite e define /public
RUN a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Render usa PORT
ENV PORT=10000
EXPOSE 10000

# Código da aplicação
COPY . /var/www/html

# Start script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["/usr/local/bin/start.sh"]
