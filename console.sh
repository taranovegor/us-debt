#!/bin/sh

docker-compose exec --user user php php -d memory_limit=2g /var/www/html/bin/console $1 $2 $3 $4
