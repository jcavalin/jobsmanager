FROM php:8.1-apache

RUN apt-get update \
	&& apt-get install -y \
	zip \
	unzip \
	git

COPY .docker/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY composer.phar ./
COPY composer.json ./
COPY composer.lock ./
RUN php composer.phar install