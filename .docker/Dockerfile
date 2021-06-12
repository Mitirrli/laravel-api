FROM php:8.0.7-fpm-alpine

ENV REDIS_VERSION=5.3.4 \
    XDEBUG_VERSION=3.0.4 \
    SWOOLE_VERSION=4.6.7 \
    PHPIZE_DEPS="autoconf g++ gcc libc-dev make zlib-dev libtool automake" \
    PHP_DEPS="oniguruma-dev curl-dev libevent-dev"

RUN \
    # set repository
    echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories \
    && echo  http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositories \
    # set package
    && apk update \
    && apk add --no-cache libstdc++ openssl git bash nodejs npm \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS $PHP_DEPS \
    # other extension
    && docker-php-ext-install bcmath pdo_mysql mysqli pcntl \
    # composer
    && wget https://mirrors.aliyun.com/composer/composer.phar -O /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer \
    && composer self-update --clean-backups \
    # redis
    && wget https://github.91chifun.workers.dev/https://github.com//phpredis/phpredis/archive/refs/tags/${REDIS_VERSION}.tar.gz -O redis.tar.gz \
    && mkdir -p redis \
    && tar -xf redis.tar.gz -C redis --strip-components=1 \
    && rm redis.tar.gz \
    && ( \
    cd redis \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r redis \
    # xdebug
    && wget https://github.91chifun.workers.dev/https://github.com//xdebug/xdebug/archive/refs/tags/${XDEBUG_VERSION}.tar.gz -O xdebug.tar.gz \
    && mkdir -p xdebug \
    && tar -xf xdebug.tar.gz -C xdebug --strip-components=1 \
    && rm xdebug.tar.gz \
    && ( \
    cd xdebug \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r xdebug \
    # swoole
    && wget https://github.91chifun.workers.dev/https://github.com//swoole/swoole-src/archive/refs/tags/v${SWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
    cd swoole \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    ) \
    && rm -r swoole \
    && echo "swoole.use_shortname = 'Off'" >> /usr/local/etc/php/conf.d/swoole.ini \
    # open extension
    && docker-php-ext-enable redis xdebug swoole \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man

COPY ini $PHP_INI_DIR/conf.d

WORKDIR /www

EXPOSE 8000

CMD tail -f /dev/null
