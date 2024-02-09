FROM php:7.4-apache

RUN apt-get update && apt-get -y --no-install-recommends install \
    git \
    libzip-dev \
    libicu-dev \
    unzip \
    libmagickwand-dev \
    libmpdec-dev \
    cron

RUN docker-php-ext-install \
    zip \
    intl \
    bcmath

RUN pecl install \
    imagick \
    decimal

RUN docker-php-ext-enable \
    imagick \
    decimal

RUN apt-get clean

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG TZ=UTC
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY docker/app/cron /etc/cron.d/cron
RUN chmod 0644 /etc/cron.d/cron
RUN crontab /etc/cron.d/cron
RUN crontab /etc/cron.d/cron

RUN sed -i 's/^exec /service cron start\n\nexec /' /usr/local/bin/apache2-foreground

COPY . .

RUN composer install \
    --no-progress \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts
