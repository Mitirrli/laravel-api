#!/bin/sh

php artisan lighthouse:clear-cache
php artisan lighthouse:cache
php artisan config:cache
php artisan route:cache
php artisan event:cache
php artisan view:cache

supervisord --nodaemon --configuration /etc/supervisord.conf
