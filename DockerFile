# Imagem base PHP 8.2 com Apache
FROM php:8.2-apache

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependências do sistema e extensão PostgreSQL
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        git \
        zip \
        unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configura Apache para servir a pasta /public e habilita mod_rewrite
RUN a2enmod rewrite \
    && sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copia o código da aplicação
COPY . /var/www/html

# Copia o script de inicialização e dá permissão
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Define permissões para storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Define comando padrão
CMD ["/usr/local/bin/start.sh"]
