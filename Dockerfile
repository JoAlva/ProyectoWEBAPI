FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar configuración personalizada de Apache
COPY app.conf /etc/apache2/sites-available/app.conf

# Habilitar tu sitio y deshabilitar el default
RUN a2dissite 000-default
RUN a2ensite app

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar archivos del proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
