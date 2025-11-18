FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer dentro del contenedor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto al servidor web
COPY . /var/www/html/

# Ir a la carpeta del proyecto
WORKDIR /var/www/html/

# Instalar dependencias de Composer (genera vendor)
RUN composer install --no-dev --optimize-autoloader

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html

# Activar módulo rewrite
RUN a2enmod rewrite

EXPOSE 80
