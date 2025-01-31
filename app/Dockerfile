FROM php:8.4-apache

WORKDIR /var/www/html

COPY ./public .
COPY ./private /var/www/private

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev      \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

RUN cd /var/www/html && mkdir -p img && chmod -R 755 img/ && chown -R www-data:www-data img/

EXPOSE 80