FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar sitio Apache
COPY app.conf /etc/apache2/sites-available/app.conf

# Activar sitio
RUN a2dissite 000-default
RUN a2ensite app.conf
RUN a2enmod rewrite

# Copiar código del proyecto
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto que Apache usa internamente
EXPOSE 80

# Iniciar Apache
CMD ["apache2-foreground"]
