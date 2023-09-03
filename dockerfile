# THIS IMAGE MUST BE USED ONLY FOR DEVELOPMENT PURPOSE
# For simplicity and speed, this image carries security risks for a production launch
# Also, the result image is way too heavy to be used in a correct CI/CD pipeline

# Private base image
FROM php:8.2-fpm-bullseye

USER root

# Install system dependencies
RUN apt update -y && apt install -y libbz2-dev zlib1g-dev libpng-dev libxml2-dev libpq-dev libxslt-dev libzip-dev libonig-dev

# Install PHP extensions
RUN pecl install redis && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip && \
    docker-php-ext-enable redis

# Install Package managers Composer and Yarn
# Set it globally like it should be on your machine
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define initial path
WORKDIR /var/www/app

# Create user and give all rights on the docker folder
RUN adduser --disabled-password www

# Set current user to www on the www group
USER www:www

# Launch FPM server
CMD ["php-fpm"]
