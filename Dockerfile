FROM php:8.2-apache

# Instalar extensiones
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar conf personalizada
COPY app.conf /etc/apache2/sites-available/app.conf

# Cambiar Listen 80 a Listen ${PORT} dinámico
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Cambiar VirtualHost de :80 a :${PORT}
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/app.conf

# Deshabilitar default y habilitar app
RUN a2dissite 000-default.conf && a2ensite app.conf

# Copiar el proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]
