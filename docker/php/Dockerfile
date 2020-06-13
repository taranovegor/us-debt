FROM php:7.4-fpm

ARG TZ=UTC

RUN apt-get update && apt-get -y --no-install-recommends install git libzip-dev libicu-dev unzip libmagickwand-dev
RUN apt-get update && apt-get -y --no-install-recommends install cron

RUN docker-php-ext-install zip intl
RUN pecl install imagick && docker-php-ext-enable imagick

RUN useradd -ms /bin/bash user
RUN usermod --shell /bin/bash www-data
RUN rm -rf /var/lib/{apt,dpkg,cache,log}/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

EXPOSE 9000
