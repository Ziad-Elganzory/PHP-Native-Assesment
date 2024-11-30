FROM php:8.3-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

# Enable Apache mod_rewrite (optional if needed)
RUN a2enmod rewrite
