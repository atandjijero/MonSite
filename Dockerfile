# Utilise une image officielle de PHP avec Apache
FROM php:8.2-apache

# Installe les extensions nécessaires, dont PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copie les fichiers de ton projet dans le dossier du serveur web
COPY . /var/www/html/

# Active le module de réécriture Apache (utile si tu as des routes propres)
RUN a2enmod rewrite

# Donne les bons droits d'accès
RUN chown -R www-data:www-data /var/www/html

# Définit le port exposé
EXPOSE 80