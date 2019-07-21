FROM composer

FROM php:7.3-fpm-alpine

ENV PHP_EXT_XDEBUG_VERSION=2.7.2

# Install PHP dependencies
# See https://github.com/docker-library/php
RUN set -ex \
    && apk add --no-cache --virtual .persistent-deps libpq libmagic icu-dev libxml2-dev libpng-dev \
    && apk add --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} postgresql-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-install gd opcache pdo pdo_pgsql bcmath intl soap \
    && pecl install xdebug-${PHP_EXT_XDEBUG_VERSION} phpredis ds \
    && docker-php-ext-enable xdebug \
    && apk del .build-dependencies

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install application/service
ENV APP_DIR /server/http/
WORKDIR ${APP_DIR}
COPY . ${APP_DIR}

## Copy PHP ini based of off https://github.com/php/php-src/blob/PHP-7.1.1/php.ini-production
COPY docker/php-fpm/php.ini ${PHP_INI_DIR}/

RUN set -ex \
    # Install project dependencies
    && composer install --prefer-dist --ignore-platform-reqs --no-interaction \
    ## Customize PHP fpm configuration
    && sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /usr/local/etc/php-fpm.conf \
    && sed -i -e "s/;request_terminate_timeout\s*=[^\n]*/request_terminate_timeout = 300/g" /usr/local/etc/php-fpm.conf \
    && php-fpm --test

ENV LOG_STREAM="/tmp/stdout"
RUN mkfifo $LOG_STREAM && chmod 777 $LOG_STREAM

CMD ["/bin/sh", "-c", "php-fpm -D | tail -f $LOG_STREAM"]
