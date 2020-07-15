#!/bin/sh

if [ -f .env.local ]; then
    export $(cat .env.local | sed 's/#.*//g' | xargs)
fi

STOP=false
DOCKER_COMPOSE_FILES="-f docker-compose.yml"

while getopts "sp" OPTION; do
    case $OPTION in
        s)
            STOP=true
            ;;
    esac
done


docker-compose $DOCKER_COMPOSE_FILES stop
if [ $STOP = true ]; then
    exit
fi
docker-compose $DOCKER_COMPOSE_FILES build
docker-compose $DOCKER_COMPOSE_FILES up -d

docker-compose exec php php -d memory_limit=2g /usr/bin/composer install
docker-compose exec php chown -R www-data:www-data /var/www/html/var/
