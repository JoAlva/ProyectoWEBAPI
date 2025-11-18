FROM php:8.2-apache

# Habilitar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar configuración Apache personalizada
COPY app.conf /etc/apache2/sites-available/app.conf

# Habilitar sitio
RUN a2dissite 000-default
RUN a2ensite app.conf

# Habilitar rewrite
RUN a2enmod rewrite

# Configurar Apache para escuchar el puerto dinámico de Railway
RUN echo "Listen ${PORT}" > /etc/apache2/ports.conf

# Copiar proyecto
COPY . /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE ${PORT}

CMD ["apache2-foreground"]
