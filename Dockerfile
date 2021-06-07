ARG PHP_VERSION=8.0.6-fpm-alpine

FROM php:${PHP_VERSION}

LABEL maintainer="Hampster <phper.blue@gmail.com>"

# Change source
RUN echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories && echo http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositories

RUN apk add --no-cache oniguruma-dev \
    gcc \
    g++ \
    curl-dev \
    libxml2-dev \
    libpng-dev freetype \
    libpng \
    libevent-dev\
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    jpeg-dev \
    libjpeg \
    libjpeg-turbo-dev \
    icu-dev \
    make \
    autoconf

RUN docker-php-ext-install pdo_mysql bcmath phpredis opcache pcntl sockets

ENV PHPREDIS_VERSION=5.3.2
RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/${PHPREDIS_VERSION}.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-${PHPREDIS_VERSION} /usr/src/php/ext/phpredis

ENV PHPSWOOLE_VERSION=4.6.7
RUN wget https://github.com/swoole/swoole-src/archive/v${PHPSWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
        cd swoole \
        && phpize \
        && ./configure --enable-mysqlnd --enable-sockets --enable-openssl --enable-http2 \
        && make -j$(nproc) \
        && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole \
    && echo "swoole.use_shortname = 'Off'" >> /usr/local/etc/php/conf.d/swoole.ini

# composer
RUN wget https://mirrors.aliyun.com/composer/composer.phar -O /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer \
    && composer self-update --clean-backups

WORKDIR /www

ADD . .

RUN composer deploy

