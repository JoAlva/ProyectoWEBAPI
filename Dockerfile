FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar configuración del host
COPY app.conf /etc/apache2/sites-available/app.conf

# Deshabilitar el sitio por defecto (si existiera)
RUN a2dissite 000-default || true

# Habilitar tu sitio
RUN a2ensite app

# Habilitar rewrite
RUN a2enmod rewrite

# Copiar proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
