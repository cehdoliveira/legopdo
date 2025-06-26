FROM php:8.3-apache

COPY gerenciador.conf /etc/apache2/sites-available/gerenciador.conf
COPY site.conf /etc/apache2/sites-available/site.conf

RUN a2ensite gerenciador.conf
RUN a2ensite site.conf

RUN apt-get update \
 && apt-get install -y apt-utils libzip-dev zlib1g-dev libpng-dev libonig-dev libxml2-dev \
 && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod headers rewrite

# Recomendações para performance e segurança
RUN docker-php-ext-enable opcache