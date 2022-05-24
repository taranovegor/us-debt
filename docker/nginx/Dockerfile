FROM nginx:1.21 AS base

WORKDIR /var/www/html/public/

RUN mkdir -p /var/run/

ARG TZ

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

ARG HOST_UID
ARG HOST_GID

RUN usermod -u $HOST_UID www-data && groupmod -g $HOST_GID www-data && chown -R www-data:www-data /var/www/

COPY ./docker/nginx/conf.d/nginx/nginx.conf /etc/nginx/nginx.conf

RUN rm /etc/nginx/conf.d/default.conf

FROM base AS development

COPY ./docker/nginx/conf.d/nginx/development/ /etc/nginx/conf.d/

FROM base AS production

COPY ./docker/nginx/conf.d/nginx/production/ /etc/nginx/conf.d/

COPY --chown=www-data:www-data ./project/public/ /var/www/html/public/
