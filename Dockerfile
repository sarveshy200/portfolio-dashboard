FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip nginx gettext-base \
    libpq-dev libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Copy nginx template
COPY nginx.conf.template /etc/nginx/conf.d/default.conf.template

# Laravel cache clear
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

RUN chmod -R 777 storage bootstrap/cache

EXPOSE 10000

CMD sh -c "envsubst '\$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf && nginx && php-fpm"
