# 1 NODE PARA FRONT Y COMPILAR ASSETS
FROM node:20-alpine AS assets-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# BACKEND PHP Y LARAVEL
FROM php:8.2-fpm-alpine


RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    icu-dev \
    oniguruma-dev \
    sqlite \
    sqlite-dev \
    $PHPIZE_DEPS

# INSTALACION DE DEP 
RUN docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl

# TRAER COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# DIRECTORIO
WORKDIR /var/www

# COPIA DE DIRECTORIO
COPY . .

# PARA TRAER LOS ASSETS DEL INICIO
COPY --from=assets-builder /app/public/build ./public/build

# INSTALAR DEP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# COMANDOS PARA LA BD
RUN touch database/database.sqlite

# PERMISOS NECESARIOS
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database

EXPOSE 9000

CMD ["php-fpm"]
