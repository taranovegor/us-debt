#!/bin/sh

docker-compose exec app php /usr/bin/composer $@
