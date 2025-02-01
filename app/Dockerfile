FROM php:8.4-apache

WORKDIR /var/www/html

COPY ./public .
COPY ./private /var/www/private

RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

RUN chown -R www-data:www-data /var/www/html/img && chmod -R 775 /var/www/html/img

EXPOSE 80