# 使用官方 PHP 7.4 镜像.
# https://hub.docker.com/_/php
FROM php:7.4-apache

ENV PORT 8080

# 将本地代码复制到容器内
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY edit-apache-config /usr/local/bin
COPY codes/ /var/www/html/
RUN a2enmod rewrite

# 安装CI4需要的PHP扩展
RUN apt-get -y update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libicu-dev git zip unzip
RUN rm -r /var/lib/apt/lists/* 
RUN docker-php-ext-install -j$(nproc) intl 
RUN pecl install mongodb && docker-php-ext-enable mongodb

RUN chown -R www-data:www-data /var/www

EXPOSE 8080

# CMD ["edit-apache-config"]

# LABEL "traefik.http.routers.ci4.rule"="Host(`ci4.trpg-linker.local`)"