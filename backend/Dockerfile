# Usamos una imagen que ya tiene PHP y Apache configurados
FROM php:8.2-apache

# Instalamos las extensiones necesarias para conectar con MySQL más adelante
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiamos vuestro código al directorio que usa Apache
COPY . /var/www/html/