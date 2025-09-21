#!/bin/bash
set -e

echo "=== Iniciando container Laravel + Apache ==="

# 1️⃣ Instala dependências PHP
if [ -f /var/www/html/composer.json ]; then
    echo "Rodando composer install e update..."
    composer install --no-interaction --optimize-autoloader
    composer update --no-interaction
fi

# 2️⃣ Ajusta permissões do Laravel
echo "Ajustando permissões de storage e bootstrap/cache..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 3️⃣ Habilita mod_rewrite do Apache
echo "Habilitando mod_rewrite..."
a2enmod rewrite

# 4️⃣ Ajusta DocumentRoot do Apache para /public
if [ -f /etc/apache2/sites-enabled/000-default.conf ]; then
    sed -i 's|DocumentRoot .*|DocumentRoot /var/www/html/public|' /etc/apache2/sites-enabled/000-default.conf
    echo "DocumentRoot atualizado para /var/www/html/public."
fi

# 6️⃣ Reinicia Apache
echo "Reiniciando Apache..."
apachectl -D FOREGROUND
