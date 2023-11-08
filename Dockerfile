FROM php:8.0-apache

RUN apt-get update && \
    apt-get install -y libpng-dev && \
    docker-php-ext-install mysqli gd

COPY ./public/ /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
