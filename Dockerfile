FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    zip \
    npm

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip \
    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
