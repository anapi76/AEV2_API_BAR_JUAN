# Dockerfile for PHP 8.2.4 with required extensions
FROM php:8.2.0-apache
#argumento
ENV DEBIAN_FRONTEND=noninteractive
# Actualizar sistema
RUN apt-get update && apt-get upgrade -y
# Instalar dependencias para intl y extensiones
RUN apt-get install -y libzip-dev zlib1g-dev libicu-dev \
    && docker-php-ext-install mysqli zip intl pdo pdo_mysql
#habilitar módulo rewrite
RUN a2enmod rewrite
# Define la nueva ruta del DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/public
# Ajusta la configuración de Apache para utilizar la nueva ruta del DocumentRoot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Establezco el directorio de trabajo
WORKDIR /var/www
# Instala la última actualización de composer
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
#Inciar el servidor en primer plano
CMD ["apache2-foreground"]







