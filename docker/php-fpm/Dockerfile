FROM composer

FROM php:7.4-fpm-alpine

ARG ENABLE_XDEBUG
ARG APCU_VERSION=5.1.11
ENV PHP_EXT_XDEBUG_VERSION=2.9.4

# Install PHP dependencies
# See https://github.com/docker-library/php
RUN set -ex \
    && apk add --no-cache --virtual .persistent-deps libpq libmagic icu-dev libxml2-dev libpng-dev make \
    && apk add --no-cache --virtual .build-dependencies ${PHPIZE_DEPS} postgresql-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-install gd opcache pdo pdo_pgsql bcmath intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && pecl install phpredis ds \
    && apk del .build-dependencies

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install application/service
ENV APP_DIR /server/http/
WORKDIR ${APP_DIR}
COPY . ${APP_DIR}

## Copy PHP ini based of off https://github.com/php/php-src/blob/PHP-7.1.1/php.ini-production
COPY docker/php-fpm/php.ini ${PHP_INI_DIR}/

RUN if [ "$ENABLE_XDEBUG" = "True" ]; then \
    pecl install xdebug-${PHP_EXT_XDEBUG_VERSION} && docker-php-ext-enable xdebug; \
    sed -i -e "s/display_errors\s+=\s+Off/display_errors = On/gi" ${PHP_INI_DIR}/php.ini; \
  fi

RUN set -ex \
    && composer global require hirak/prestissimo \
    # Install project dependencies
    && composer install --prefer-dist --ignore-platform-reqs --no-interaction \
    ## Customize PHP fpm configuration
    && sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /usr/local/etc/php-fpm.conf \
    && sed -i -e "s/;request_terminate_timeout\s*=[^\n]*/request_terminate_timeout = 300/g" /usr/local/etc/php-fpm.conf \
    && php-fpm --test \
    && composer dumpautoload -o
