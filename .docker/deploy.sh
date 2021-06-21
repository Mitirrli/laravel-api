#!/bin/sh

# example => ./deploy.sh 0.0.2

echo '当前部署的版本号为'$1

docker login
docker build -t hampster/php-cli-base:$1 base
docker push hampster/php-cli-base:$1