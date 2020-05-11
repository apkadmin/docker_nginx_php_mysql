FROM php:fpm
RUN apt-get update && apt-get install -y vim && apt-get install -y wget
RUN docker-php-ext-install pdo pdo_mysql mysqli
#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/
RUN chown -R www-data /var/www
RUN chmod 755 /var/www
COPY config/php.ini /usr/local/etc/php/