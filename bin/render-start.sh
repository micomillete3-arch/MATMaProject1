#!/bin/sh
set -e

export APP_ENV=production
export APP_DEBUG=false
export LOG_CHANNEL=stderr
export SESSION_DRIVER=file
export CACHE_STORE=file
export QUEUE_CONNECTION=sync
export FILESYSTEM_DISK=local
export BROADCAST_CONNECTION=log

missing_vars=""
for var in APP_KEY DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD; do
    if [ -z "$(printenv "$var")" ]; then
        missing_vars="$missing_vars $var"
    fi
done

if [ -n "$missing_vars" ]; then
    echo "Warning: missing Render environment variables:$missing_vars" >&2
fi

php artisan optimize:clear

if [ -z "$missing_vars" ]; then
    php artisan migrate --force || echo "Warning: migrations failed; starting web server so diagnostics are reachable." >&2
    php artisan db:seed --class=AccessControlSeeder --force || echo "Warning: default account seeding failed." >&2
else
    echo "Warning: skipping migrations because required database/app variables are missing." >&2
fi

echo "Starting Laravel on port ${PORT:-10000}"
php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
