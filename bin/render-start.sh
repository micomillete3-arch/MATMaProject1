#!/bin/sh
set -e

for var in APP_KEY DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD; do
    if [ -z "$(printenv "$var")" ]; then
        echo "Missing required environment variable: $var" >&2
        exit 1
    fi
done

php artisan optimize:clear
php artisan migrate --force

echo "Starting Laravel on port ${PORT:-10000}"
php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
