#!/bin/sh

php artisan lighthouse:clear-cache

supervisord --nodaemon --configuration /etc/supervisord.conf
