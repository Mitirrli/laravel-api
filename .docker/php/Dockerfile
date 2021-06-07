ARG PHP_VERSION=8.0.6-fpm-alpine
FROM php:${PHP_VERSION}

RUN echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories \
    && echo  http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositorie

RUN apk add --no-cache oniguruma-dev \
    nodejs \
    npm \
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
    gcc \
    g++ \
    make \
    autoconf \
    zsh

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd bcmath pdo_mysql mysqli opcache intl pcntl sockets

RUN wget https://mirrors.aliyun.com/composer/composer.phar -O /usr/local/bin/composer \
    && chmod a+x /usr/local/bin/composer \
    && composer config -g repo.packagist composer https://mirrors.aliyun.com/composer \
    && composer self-update --clean-backups

ENV PHPREDIS_VERSION=5.3.4
RUN wget http://pecl.php.net/get/redis-${PHPREDIS_VERSION}.tgz -O /tmp/redis.tar.tgz \
    && pecl install /tmp/redis.tar.tgz \
    && rm -rf /tmp/redis.tar.tgz \
    && docker-php-ext-enable redis

ENV PHPXDEBUG_VERSION=3.0.4
RUN wget http://pecl.php.net/get/xdebug-${PHPXDEBUG_VERSION}.tgz -O /tmp/xdebug.tar.tgz \
    && pecl install /tmp/xdebug.tar.tgz \
    && rm -rf /tmp/xdebug.tar.tgz \
    && docker-php-ext-enable xdebug \
    && echo 'xdebug.mode = debug' > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.start_with_request = yes' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.client_host = 192.168.0.132' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.client_port = 9000' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.log_level = 0' >> /usr/local/etc/php/conf.d/xdebug.ini

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

RUN echo 'error_reporting = E_ALL & ~E_NOTICE' >> /usr/local/etc/php/conf.d/error.ini \
    && echo 'display_errors = On' >> /usr/local/etc/php/conf.d/error.ini

WORKDIR /www

EXPOSE 8000

CMD tail -f /dev/null
