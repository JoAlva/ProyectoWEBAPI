FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar archivos del proyecto ANTES de configurar Apache
COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Copiar configuración personalizada de Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilitar tu sitio
RUN a2ensite 000-default.conf

EXPOSE 80
