FROM php:7.2.24-apache
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = 1024M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini