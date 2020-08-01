FROM php:8.0.0alpha3-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

ADD . /var/www/html
