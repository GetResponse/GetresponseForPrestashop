FROM php:8.4-cli as php8
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
WORKDIR /plugin
COPY --from=docker.int.getresponse.com/docker/composer:2 /usr/bin/composer /usr/bin/composer
COPY . ./
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        unzip
RUN composer update --no-interaction --prefer-dist --no-suggest --no-cache
RUN printf "zend_extension=xdebug.so\nxdebug.mode=debug\nxdebug.start_with_request=trigger\nxdebug.client_port=9003\nxdebug.idekey=PHPSTORM\nxdebug.client_host=host.docker.internal\nxdebug.log=/proc/self/fd/2\n" > $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

ENTRYPOINT [ "/bin/bash", "-c", "tail -f /dev/null" ]
