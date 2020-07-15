FROM php:7.4-cli

ARG TZ=UTC
ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get -y --no-install-recommends install git libzip-dev unzip libmagickwand-dev libmpdec-dev cron

RUN docker-php-ext-install zip bcmath
RUN pecl install imagick decimal && docker-php-ext-enable imagick decimal

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN rm -rf /var/lib/{apt,dpkg,cache,log}/

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN usermod --shell /bin/bash www-data && usermod -u $UID www-data && groupmod -g $GID www-data
RUN chown www-data:www-data /var/www

USER www-data:www-data

EXPOSE 9000
