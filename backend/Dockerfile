# Usamos una imagen que ya tiene PHP y Apache configurados
FROM php:8.2-apache

# Instalamos las extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitamos el módulo rewrite de Apache para que funcione el .htaccess
RUN a2enmod rewrite

# Cambiamos el DocumentRoot de Apache a la carpeta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiamos vuestro código al directorio que usa Apache
COPY . /var/www/html/