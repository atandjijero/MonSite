# Image de base : PHP 8.1 avec Apache
FROM php:8.1-apache

# Mise à jour des paquets + installation de libpq-dev pour PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Active le module rewrite d’Apache (utile si tu as .htaccess ou des routes propres)
RUN a2enmod rewrite

# Copie les fichiers de ton dossier public dans le dossier Apache
COPY public/ /var/www/html/

# Applique les bons droits d’accès
RUN chown -R www-data:www-data /var/www/html

# Expose le port 80 (HTTP)
EXPOSE 80