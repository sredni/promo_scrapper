##### BASE IMAGE
FROM php:7.2-fpm-stretch AS scrapper-base

# Install PHP extensions and PECL modules.
RUN deps="curl \
        git \
        libicu-dev \
        libbz2-dev \
        libzip-dev \
        libxml2-dev \
        gnupg2 \
        ffmpeg \
    " \
    && apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y $deps \
    && docker-php-ext-install exif iconv intl mbstring opcache zip \
    && mkdir -p /var/www/ \
    && apt-get clean \
    #composer
    && mkdir -p ~/.ssh/ \
    && echo "|1|ulCB5COY6sEErUSw4ZrvPRcjmvY=|DIDgfrXNV/sE2oHTsGa4aaDNru8= ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCYHBNobwYOyrLabwuE6edHTUj4eHYRswbpQYbDX/O9gKORYPZRexs0FMPKucRPcNdw455cuamKLAzk9VL0eIN7vKAbww05PkuhlcVGvo0UdiVqqF8h5T1wYGVUooCOcnpvLnioFo6cIuFE9m13fIyDAA6DoD3PmnLyzBpsKYqrPWGUw/lq6bSdz9feq+DG/MQ0aopIXuoZ73/KsWfkx91f14SxfaZgANlpMqj1v+XJd/z7QbmoQTVIwPPI9YyfqfU8r1vk0/6PY3DaSZ1zWLFCh2217lktxthG5/QF9Y3hnsGLhEeJD7U+vGM+JZnISDGgie8ac/yH7tlb5QkDFgsv" >> ~/.ssh/known_hosts \
    && curl -sL https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

COPY docker/scrapper/files/base /usr/local
WORKDIR /var/www/scrapper/

##### DEV IMAGE
FROM scrapper-base AS scrapper-dev

COPY docker/scrapper/files/dev /usr/local

RUN apt-get update \
    && pecl install xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir -p /var/www/ \
    && chmod +x /usr/local/bin/php-xdebug

ENTRYPOINT ["bash", "-c"]
CMD ["php-fpm -y /usr/local/etc/php-fpm-dev.conf -c /usr/local/etc/php-dev -D; php-fpm"]

##### APP IMAGE
FROM scrapper-base AS scrapper-app

COPY . /var/www/scrapper
RUN /usr/local/bin/composer install \
    && chown -R www-data: .