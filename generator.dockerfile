# THIS IMAGE MUST BE USED ONLY FOR DEVELOPMENT PURPOSE

# Private base image
FROM php:8.2-fpm-bullseye

# Define current user
USER root

# Install system dependencies
RUN apt update -y && apt install git zip -y

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Define initial path
WORKDIR /var/www/app

# Create a new app
RUN composer create-project laravel/laravel

# CMD ["composer", "create-project", "laravel/laravel", "&&", "cp", "-r", "laravel/*", ".."]