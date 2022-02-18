#!/bin/ash
set -e

# Image-specific actions
if [ "${IMG_ENV}" = "dev" ]; then
    # It's for dev
    rm -rf var/cache/*
    composer install --prefer-dist --no-progress --no-interaction
fi

setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var
setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var

RETRY=60
until [ $RETRY -eq 0 ] || ERROR=$(bin/console doctrine:dbal:run-sql "SELECT 1" 2>&1); do
  sleep 1
  echo "Try to connect to database... $RETRY retries left"

  retry=$((retry - 1))

  break
done
if [ $retry -eq 0 ]; then
  echo "Can't connect to database..."
  echo "$ERROR"
  exit 1
else
  echo "Connected to database successfully"
fi

if ls -A migrations/*.php >/dev/null 2>&1; then
    bin/console doctrine:migrations:migrate --no-interaction --all-or-nothing
fi

echo "running php-fpm"
exec php-fpm