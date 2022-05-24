ARG PHP_MODE
ARG PHP_ROLE

FROM php:7.4-${PHP_MODE} AS base

WORKDIR /var/www/html/

RUN apt-get update && apt-get -y --no-install-recommends install \
    git \
    libzip-dev \
    unzip \
    libmagickwand-dev \
    libmpdec-dev \
    cron

RUN rm -rf /var/lib/{apt,dpkg,cache,log}/

COPY --from=mlocati/php-extension-installer:1.5 /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    intl \
    zip \
    bcmath \
    imagick \
    decimal

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG TZ

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

ARG HOST_UID
ARG HOST_GID

RUN usermod -u $HOST_UID www-data && groupmod -g $HOST_GID www-data && chown -R www-data:www-data /var/www/

COPY ./docker/php/conf.d/php/common/ /usr/local/etc/php/conf.d/

ARG PHP_ROLE
COPY ./docker/php/conf.d/${PHP_ROLE}/php/common/ /usr/local/etc/php/conf.d/

FROM base AS build-role-cron

RUN apt-get update && apt-get -y --no-install-recommends install \
    cron \
    logrotate

COPY ./docker/php/conf.d/cron/cron/crontab /crontab
COPY ./docker/php/conf.d/cron/logrotate/logrotate.conf /logrotate.conf

RUN crontab -u www-data /crontab

CMD ["cron", "-f", "-l", "8"]

FROM build-role-${PHP_ROLE} AS development

RUN install-php-extensions xdebug-3.1.1

COPY ./docker/php/conf.d/php/development/ /usr/local/etc/php/conf.d/

ARG PHP_ROLE
COPY ./docker/php/conf.d/${PHP_ROLE}/php/development/ /usr/local/etc/php/conf.d/

FROM build-role-${PHP_ROLE} AS production

RUN apt-get clean

COPY ./docker/php/conf.d/php/production/ /usr/local/etc/php/conf.d/

ARG PHP_ROLE
COPY ./docker/php/conf.d/${PHP_ROLE}/php/production/ /usr/local/etc/php/conf.d/

RUN mkdir -p vendor var var/log vendor && chown www-data:www-data var var/log vendor

COPY --chown=www-data:www-data ./ /var/www/html/
