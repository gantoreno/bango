FROM php:7.2.2-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

ADD . /var/www/html
