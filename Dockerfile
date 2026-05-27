FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
git unzip curl libzip-dev zip libpng-dev nodejs npm \
&& docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

ENV APP_ENV=production
ENV LOG_CHANNEL=stderr

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN npm install && npm run build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD ["sh", "bin/render-start.sh"]
