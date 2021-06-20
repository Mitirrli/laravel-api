ARG TAG=0.0.2
FROM hampster/php-cli-base:${TAG}

LABEL maintainer="Hampster <phper.blue@gmail.com>"

# add opcache
RUN docker-php-ext-install opcache

COPY .docker/base/opcache/* $PHP_INI_DIR/conf.d

ADD . .

RUN composer deploy

ADD supervisord.conf /etc/

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

