FROM php:7.2-fpm-alpine

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
    && apk update && apk add \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
	    zip unzip \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        opcache \
    && docker-php-ext-enable pdo_mysql
