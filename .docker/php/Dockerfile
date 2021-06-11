FROM registry.cn-hangzhou.aliyuncs.com/back-code/php8-cli:latest

ENV XDEBUG_VERSION=3.0.4 \
    PHPIZE_DEPS="autoconf gcc g++ make"

RUN echo http://mirrors.aliyun.com/alpine/v3.12/main > /etc/apk/repositories \
    && echo  http://mirrors.aliyun.com/alpine/v3.12/community >> /etc/apk/repositorie

# 使用xdebug进行调试
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && wget http://pecl.php.net/get/xdebug-${XDEBUG_VERSION}.tgz -O /tmp/xdebug.tar.tgz \
    && pecl install /tmp/xdebug.tar.tgz \
    && rm -rf /tmp/xdebug.tar.tgz \
    && docker-php-ext-enable xdebug \
    && echo 'xdebug.mode = debug' > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.start_with_request = yes' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.client_host = 192.168.0.132' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.client_port = 9000' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.log_level = 0' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man

WORKDIR /www

EXPOSE 8000

CMD tail -f /dev/null
