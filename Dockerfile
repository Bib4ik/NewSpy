FROM php:8.2-apache
# Устанавливаем расширения для работы с БД
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Устанавливаем zip и git для Composer
RUN apt-get update && apt-get install -y zip unzip git libzip-dev \
    && docker-php-ext-install zip
# Копируем файлы проекта в папку сервера
COPY . /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer