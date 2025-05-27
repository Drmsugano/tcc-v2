#!/bin/bash

# Executa o composer install e update
composer install
composer update

# Localiza e substitui a linha no arquivo 000-default.conf para definir o diretório raiz do Apache
if [ -f /etc/apache2/sites-enabled/000-default.conf ]; then
    sed -i 's|DocumentRoot .*|DocumentRoot /var/www/html/public|' /etc/apache2/sites-enabled/000-default.conf
    echo "DocumentRoot foi atualizado para /var/www/html/public."
else
    echo "Arquivo 000-default.conf não encontrado."
fi

# Executa o Apache
exec apache2-foreground