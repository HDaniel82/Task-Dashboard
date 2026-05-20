FROM php:8.2-apache

# Install the PHP extensions needed for MySQL connections
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite for cleaner URLs later
RUN a2enmod rewrite