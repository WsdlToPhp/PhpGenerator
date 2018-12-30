FROM php:7.1-apache

RUN apt-get update \
    && apt-get install -y git zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html

WORKDIR /var/www/html