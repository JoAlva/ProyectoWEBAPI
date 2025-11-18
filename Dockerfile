FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar Apache para escuchar el puerto dinámico de Railway
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:${PORT}>/" /etc/apache2/sites-available/app.conf

# Copiar configuración personalizada de Apache
COPY app.conf /etc/apache2/sites-available/app.conf

# Habilitar tu sitio
RUN a2dissite 000-default.conf && a2ensite app.conf

# Copiar archivos de la app
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto dinámico
EXPOSE ${PORT}

CMD ["apache2-foreground"]
