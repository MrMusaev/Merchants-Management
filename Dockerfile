FROM php:8.2-fpm

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y git postgresql-client unzip && apt-get install -y netcat

RUN chmod +x /usr/local/bin/install-php-extensions && sync && install-php-extensions gd zip soap pdo_pgsql redis pcntl

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/default

CMD "/usr/local/sbin/php-fpm"
