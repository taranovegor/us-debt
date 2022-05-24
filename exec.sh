#!/bin/sh

user=www-data
command=''
while [ $# -gt 0 ]; do
    case $1 in
        -u|--user) user=$2; shift ;;
        -c|--container) container=$2; shift ;;
        *) command="$command $1" ;;
    esac; shift
done

if [ -z "$container" ]; then
    echo 'Define the container to run'
    exit 2
fi

docker-compose exec -T --user $user $container $command
