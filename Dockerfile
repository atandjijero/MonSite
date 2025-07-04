FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql

RUN a2enmod rewrite

COPY public/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80