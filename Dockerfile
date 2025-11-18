FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos del proyecto al servidor web
COPY . /var/www/html/

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html

# Activar módulo rewrite (por si usas rutas amigables)
RUN a2enmod rewrite

EXPOSE 80
