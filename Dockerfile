# Instalar y habilitar Apache + PHP
FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

# 1. Copiar archivo app.conf primero
COPY app.conf /etc/apache2/sites-available/app.conf

# 2. Modificar puertos dinámicos
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/app.conf

# 3. Habilitar sitio
RUN a2dissite 000-default.conf && a2ensite app.conf

# 4. Copiar proyecto
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
