FROM registry.cn-hangzhou.aliyuncs.com/back-code/php8-cli:latest

LABEL maintainer="Hampster <phper.blue@gmail.com>"

WORKDIR /www

ADD . .

RUN composer deploy

COPY .docker/ini/99_default.ini $PHP_INI_DIR/conf.d/
COPY .docker/ini/99_opcache.ini $PHP_INI_DIR/conf.d/

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/www/supervisord.conf"]
