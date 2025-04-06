#!/bin/bash

# Espera o MySQL subir
until nc -z mysql 3306; do
  echo "Aguardando o MySQL subir..."
  sleep 2
done

# Verifica se o Composer já gerou o autoload
if [ ! -f "vendor/autoload.php" ]; then
  echo "Aguardando o autoload do Composer ser gerado..."

  # Aguarda até o arquivo existir
  while [ ! -f "vendor/autoload.php" ]; do
    sleep 2
  done

  echo "Autoload encontrado. Continuando..."
fi

echo "Iniciando o Laravel Queue Worker..."

# Não executa migrate nem npm, só inicia o queue
php artisan queue:work --tries=3 --timeout=60 --verbose --no-interaction
