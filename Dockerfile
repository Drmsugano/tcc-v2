# Usa imagem oficial do PHP com Apache
FROM php:8.4-apache

# Instala extensões necessárias do PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Ativa mod_rewrite do Apache
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório do app
WORKDIR /var/www/html

# Copia os arquivos do Laravel pro container
COPY . .

# Dá permissão para o Laravel funcionar
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Define a porta
EXPOSE 80