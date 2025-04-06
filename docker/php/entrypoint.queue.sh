#!/bin/bash

# Espera o MySQL subir
until nc -z mysql 3306; do
  echo "Aguardando o MySQL subir..."
  sleep 2
done

# Composer deps (se volume montado)
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Gera .env e key se não existir
if [ ! -f ".env" ]; then
  cp .env.example .env
  php artisan key:generate
fi

# Permissões
chown -R www-data:www-data storage bootstrap/cache

echo "Iniciando o Laravel Queue Worker..."

# Não executa migrate nem npm, só inicia o queue
php artisan queue:work --tries=3 --timeout=60 --verbose --no-interaction
