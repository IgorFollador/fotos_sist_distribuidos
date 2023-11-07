FROM php:8.0-apache

RUN apt-get update && \
    apt-get install -y libpng-dev && \
    docker-php-ext-install mysqli gd

COPY ./public/ /var/www/html/

ENV DB_HOST=""
ENV DB_USER=""
ENV DB_PASSWORD=""
ENV DB_NAME=""
ENV ACCESS_KEY=""
ENV SECRET_KEY=""
ENV BUCKET_NAME=""

EXPOSE 80

CMD ["apache2-foreground"]
