ARG PHP_VERSION=8.0.7
FROM php:${PHP_VERSION}-cli-alpine

# 推送指令
# docker build -t registry.cn-hangzhou.aliyuncs.com/back-code/php8-cli:latest .
# docker push registry.cn-hangzhou.aliyuncs.com/back-code/php8-cli:latest

LABEL maintainer="Hampster <phper.blue@gmail.com>"
LABEL description="基础镜像"

ENV REDIS_VERSION=5.3.4 \
    SWOOLE_VERSION=4.6.7 \
    COMPOSER_VERSION=2.1.3 \
    PHPIZE_DEPS="autoconf dpkg-dev dpkg file g++ gcc libc-dev pkgconf re2c pcre-dev pcre2-dev zlib-dev libtool make automake" \
    BUSINESS_DEPS="oniguruma-dev curl-dev libevent-dev"

RUN echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories \
    && echo http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositories

RUN apk update \
    && apk add --no-cache libstdc++ openssl git bash supervisor \
    && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS $BUSINESS_DEPS \
    # redis
    && curl -L -o /tmp/redis.tar.gz https://github.91chifun.workers.dev/https://github.com//phpredis/phpredis/archive/refs/tags/${REDIS_VERSION}.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-${REDIS_VERSION} /usr/src/php/ext/phpredis \
    # other
    && docker-php-ext-install opcache mbstring pdo_mysql bcmath phpredis pcntl \
    # swoole
    && wget https://gitee.com/swoole/swoole/repository/archive/v${SWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
        cd swoole \
        && phpize \
        && ./configure --enable-mysqlnd --enable-openssl --enable-http2 \
        && make -j$(nproc) \
        && make install \
    ) \
    && rm -r swoole \
    && echo "swoole.use_shortname = 'Off'" >> $PHP_INI_DIR/conf.d/50_swoole.ini \
    && docker-php-ext-enable swoole \
    # composer
    && wget -nv -O /usr/local/bin/composer https://github.com/composer/composer/releases/download/${COMPOSER_VERSION}/composer.phar \
    && chmod u+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer \
    && composer self-update --clean-backups \
    # info
    && php -v \
    && php -m \
    && php --ri swoole \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man
