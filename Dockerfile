FROM php:7.3-cli-buster
RUN docker-php-ext-install pdo pdo_mysql
CMD php -S 0.0.0.0:8000 -t /src/public