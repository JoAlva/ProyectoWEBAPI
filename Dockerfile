FROM php:8.2-apache

# Extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar configuración de Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar aplicación
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Activar mod_rewrite
RUN a2enmod rewrite

EXPOSE 80
