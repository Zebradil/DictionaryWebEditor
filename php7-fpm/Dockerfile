FROM php:fpm-alpine

RUN apk update \
 && apk --no-cache add \
                       git \
                       unzip \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk update \
 && apk --no-cache add \
                       icu-dev \
                       postgresql-dev \
 && docker-php-ext-install \
                           opcache \
                           pdo_pgsql \
                           intl \
 && echo "short_open_tag=off" >> /usr/local/etc/php/conf.d/symfony.ini

RUN apk update \
 && apk --no-cache add \
                       gcc \
                       g++ \
                       make \
                       autoconf \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug \
 && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
 && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY ./start.sh /opt/start.sh

WORKDIR /var/www/symfony

CMD ["/opt/start.sh"]
