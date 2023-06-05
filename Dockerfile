FROM php:5.6-cli as php5
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN pecl update-channels
RUN pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug
WORKDIR /plugin
COPY --from=docker.int.getresponse.com/docker/composer:2.2.9 /usr/bin/composer /usr/bin/composer
COPY . ./
RUN sed -i -e 's/deb.debian.org/archive.debian.org/g' \
           -e 's|security.debian.org|archive.debian.org/|g' \
           -e '/stretch-updates/d' /etc/apt/sources.list
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        unzip
RUN composer install --no-interaction --prefer-dist --no-suggest --no-cache
ENTRYPOINT [ "/bin/bash", "-c", "tail -f /dev/null" ]

FROM php:7.1-cli as php7
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN pecl update-channels
RUN pecl install xdebug-2.9.0 \
    && docker-php-ext-enable xdebug
WORKDIR /plugin
COPY --from=docker.int.getresponse.com/docker/composer:2.2.9 /usr/bin/composer /usr/bin/composer
COPY . ./
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        unzip
RUN composer install --no-interaction --prefer-dist --no-suggest --no-cache
ENTRYPOINT [ "/bin/bash", "-c", "tail -f /dev/null" ]



