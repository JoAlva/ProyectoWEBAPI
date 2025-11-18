FROM php:8.2-apache

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar config
COPY app.conf /etc/apache2/sites-available/app.conf

# Deshabilitar default y activar tu sitio
RUN a2dissite 000-default.conf && a2ensite app.conf

# Copiar tu proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Railway asigna este puerto dinámicamente
EXPOSE 8080

# Apache debe correr en FOREGROUND
CMD ["apache2-foreground"]
