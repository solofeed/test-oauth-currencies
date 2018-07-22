FROM php:7.2-fpm

ENV REFRESHED_AT 22-07-2018

RUN apt-get update && apt-get install -y \
       git \
       apt-transport-https \
       zlib1g-dev \
       libfreetype6-dev \
       libjpeg62-turbo-dev \
       libmemcached-dev \
       libz-dev

RUN docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Some cleanup
RUN apt-get -q autoremove &&\
    apt-get -q clean -y && rm -rf /var/lib/apt/lists/* && rm -f /var/cache/apt/*.bin

# Starting directory
WORKDIR /var/www