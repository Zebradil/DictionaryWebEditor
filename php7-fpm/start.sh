#!/bin/sh

cd /var/www/symfony;

composer install

#ln -sfn /dev/stdout var/logs/dev.log
mkdir -p var/cache var/logs var/sessions;
chown www-data:www-data -R var/cache var/logs var/sessions;

./bin/console doctrine:database:create --if-not-exists --no-interaction --verbose
./bin/console doctrine:schema:update --complete --force --no-interaction --verbose

php-fpm;
