FROM php:8.2-fpm

ARG DOCKER_USER_ID

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libimage-exiftool-perl

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash
#  If npm is not installed, uncomment this. This should make sure that the nodesource version is used, not the debian one.
#  RUN echo 'Package: *\nPin: origin deb.nodesource.com\nPin-Priority: 600' > /etc/apt/preferences.d/nodesource
RUN apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mysqli zip exif pcntl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
ARG DOCKER_USER_ID=1000
RUN groupadd -g $DOCKER_USER_ID www
RUN useradd -u $DOCKER_USER_ID -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Start php-fpm server
CMD php-fpm
