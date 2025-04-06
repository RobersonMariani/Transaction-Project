#!/bin/bash

# Espera o MySQL subir
until nc -z mysql 3306; do
  echo "Aguardando o MySQL subir..."
  sleep 2
done

# Rodar isso só se a pasta vendor ainda não existe (evita reexecuções desnecessárias)
if [ ! -d "vendor" ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Mesmo para node_modules
if [ ! -d "node_modules" ]; then
  npm install
fi

# Gera key se não existir
if [ ! -f ".env" ]; then
  cp .env.example .env
  php artisan key:generate
fi

# Rodar migrations (idempotente)
php artisan migrate --force || true

# Permissões
chown -R www-data:www-data storage bootstrap/cache

# Executa o PHP-FPM
exec php-fpm
