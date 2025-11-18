FROM php:8.2-apache

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar configuración personalizada
COPY app.conf /etc/apache2/sites-available/app.conf

# Habilitar el sitio personalizado y deshabilitar el default
RUN a2dissite 000-default.conf && a2ensite app.conf

# Copiar el código de la app
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
