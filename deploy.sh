#!/bin/sh

if [ -f .env.local ]; then
    export $(cat .env.local | sed 's/#.*//g' | xargs)
fi

docker_compose_options="-f docker-compose.yaml"

while [ $# -gt 0 ]; do
    case $1 in
        -s|--stop) stop=true ;;
        -p|--production) production="1" ;;
    esac; shift
done

if [ -z "$production" ]; then
    echo "❗ Building the application in the development environment"
    docker_compose_options="$docker_compose_options -f docker-compose.dev.yaml"
else
    echo "❗ Building the application in the production environment"
    docker_compose_options="$docker_compose_options -f docker-compose.prod.yaml"
fi

if [ ! -z "$stop" ]; then
    docker-compose $docker_compose_options down --remove-orphans
    exit 0
fi

docker-compose $docker_compose_options build --compress --parallel --force-rm
docker-compose $docker_compose_options up --detach --remove-orphans --force-recreate
docker-compose $docker_compose_options ps

./composer.sh install
