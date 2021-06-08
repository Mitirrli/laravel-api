FROM php:8.0.7-fpm-alpine

LABEL maintainer="Hampster <phper.blue@gmail.com>"

RUN echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories && echo http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositories

RUN apk update \
    && apk add --no-cache oniguruma-dev \
    git \
    gcc \
    g++ \
    gzip \
    openssl \
    libaio-dev \
    openssl-dev \
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
    autoconf \
    supervisor

ENV REDIS_VERSION=5.3.4
RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/${REDIS_VERSION}.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-${REDIS_VERSION} /usr/src/php/ext/phpredis

RUN docker-php-ext-install pdo_mysql bcmath phpredis opcache pcntl sockets

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
    && echo "memory_limit = 1G" > /usr/local/etc/php/conf.d/00_default.ini \
    && echo "opcache.enable = 1" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.memory_consumption=512" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.save_comments = 0" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.validate_timestamps = 0" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.fast_shutdown = 1" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.jit = 1205" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.jit_buffer_size = 64M" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "opcache.enable_cli = 'On'" >> /usr/local/etc/php/conf.d/00_opcache.ini \
    && echo "swoole.use_shortname = 'Off'" >> /usr/local/etc/php/conf.d/50_swoole.ini

WORKDIR /www

ADD . .

# composer
RUN wget https://mirrors.aliyun.com/composer/composer.phar -O /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer \
    && composer self-update --clean-backups \
    && composer deploy

ADD supervisord.conf /etc/

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

