FROM composer/composer:2.7.9 as composer
FROM node:22.9.0 as node
FROM php:8.3-fpm


ARG USER_NAME=host-user
ARG USER_ID=1000
ARG PHP_FPM_GROUP=www-data


RUN adduser \
        --disabled-password \
        --uid ${USER_ID} \
        ${USER_NAME} \
    && usermod \
        --append \
        --groups \
        ${PHP_FPM_GROUP} \
        ${USER_NAME}

RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    bash \
    nginx \
    libzip-dev\
    libpq-dev \
    supervisor

RUN apt clean && rm -rf /var/lib/apt/lists/*
RUN pecl install redis
RUN docker-php-ext-install pdo_pgsql zip  

RUN docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=node --chown=${USER_NAME}:root /usr/local/bin/node /usr/local/bin/node 
COPY --from=node --chown=${USER_NAME}:root /usr/local/lib/node_modules /usr/local/lib/node_modules


RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN ln -s /usr/local/lib/node_modules/npx/bin/npx-cli.js /usr/local/bin/npx

RUN mkdir -p /home/${USER_NAME}/.composer && \
    chown -R ${USER_NAME}:root /home/${USER_NAME}

COPY ./nginx.conf /etc/nginx/sites-enabled/default
COPY ./php-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /application



RUN service nginx start


COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]