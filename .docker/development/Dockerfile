ARG TAG=0.0.2
FROM hampster/php-cli-base:${TAG}

LABEL maintainer="Hampster <phper.blue@gmail.com>"

ENV XDEBUG_VERSION=3.0.4 \
    PHPIZE_DEPS="autoconf g++ gcc make automake"

RUN \
    # set repository
    echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories \
    && echo  http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositories \
    # set package
    && apk update \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
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
    # open extension
    && docker-php-ext-enable xdebug \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man

COPY xdebug/* $PHP_INI_DIR/conf.d

EXPOSE 8000

CMD tail -f /dev/null
