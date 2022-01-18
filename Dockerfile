FROM php:5.6-cli as php5
WORKDIR /plugin/
COPY --from=docker.int.getresponse.com/docker/composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN --mount=type=ssh composer install --prefer-dist --no-suggest --no-cache --no-autoloader
COPY . ./

FROM php:7.1-cli as php7
WORKDIR /plugin/
COPY . ./