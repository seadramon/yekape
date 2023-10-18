FROM php:8.1.4-fpm

RUN apt-get update && apt-get -y install git && apt-get -y install zip

RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    zlib1g-dev \
    libzip-dev \
    libpq-dev \
    libgd-dev \
    xvfb \
    iproute2 \
    libfontconfig \
    wkhtmltopdf \
    libmagickwand-dev \
    wget libarchive-tools libaio1

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# install redis
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-configure zip
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql bcmath
RUN ln -s /usr/bin/wkhtmltopdf /usr/local/bin/wkhtmltopdf
RUN pecl install imagick && docker-php-ext-enable imagick

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN pecl install swoole
# RUN docker-php-ext-enable swoole
