FROM php:8.3

FROM dunglas/frankenphp

USER root

WORKDIR /var/www

RUN apt-get update && apt install -y curl

# Install environment dependencies
RUN apt-get update \
        # gd
        && apt-get install -y build-essential openssl libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev  \
        && docker-php-ext-configure gd  \
        && docker-php-ext-install gd \

        # gmp
        && apt-get install -y --no-install-recommends libgmp-dev \
        && docker-php-ext-install gmp \
        # pdo_mysql
        && docker-php-ext-install pdo_mysql mbstring \
        # pdo
        && docker-php-ext-install pdo \
        # opcache
        && docker-php-ext-enable opcache \
        # exif
        && docker-php-ext-install exif \
        && docker-php-ext-install sockets \
        && docker-php-ext-install pcntl \
        && docker-php-ext-install bcmath \
        # zip
        && docker-php-ext-install zip \
        && apt-get autoclean -y \
        && rm -rf /var/lib/apt/lists/* \
        && rm -rf /tmp/pear/

RUN install-php-extensions pcntl

COPY . /var/www

COPY ./deploy/local.ini /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --prefer-dist --no-interaction --ignore-platform-reqs --no-dev -a

RUN php artisan cache:clear

RUN php artisan config:clear

RUN php artisan route:clear

RUN php artisan octane:install --server=frankenphp

RUN composer dump-autoload

COPY deploy/start.sh /var/www/start.sh

RUN chmod u+x /var/www/start.sh

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]