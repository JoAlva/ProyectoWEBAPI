FROM php:8.2-apache

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar configuración personalizada
COPY app.conf /etc/apache2/sites-available/app.conf

# Cambiar Listen 80 por el puerto dinámico de Railway ($PORT)
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Cambiar VirtualHost :80 → :${PORT}
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/app.conf

# Deshabilitar default y activar tu sitio
RUN a2dissite 000-default.conf && a2ensite app.conf

# Copiar tu proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Comando de ejecución
CMD ["apache2-foreground"]
