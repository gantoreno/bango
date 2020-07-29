DockerfileSELECT * FROM `inventory_purchase_order_consumable` WHERE `ipoc_id` = '9328';FROM php:7.2.2-apache

RUN a2enmod rewrite
RUN docker-php-ext-install mysqli

ADD . /var/www/html
