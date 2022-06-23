FROM php:8.1-cli

RUN apt-get update \ 
  && apt-get install -y libzip-dev libicu-dev

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install zip
RUN docker-php-ext-install intl

WORKDIR /app
