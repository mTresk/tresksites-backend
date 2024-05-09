FROM php:8.3

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

WORKDIR /var/www

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=ghcr.io/roadrunner-server/roadrunner:latest /usr/bin/rr /usr/local/bin/rr

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libwebp-dev \
      libjpeg-dev \
      libzip-dev \
      libicu-dev \
      zip unzip \
      nano \
      cron \
      supervisor \
      git && \
      curl -sLS https://deb.nodesource.com/setup_20.x | bash - && \
      apt-get install -y nodejs && \
      npm install -g npm && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN install-php-extensions pcntl opcache pdo_mysql bcmath exif zip intl gd sockets

# Add user for Laravel application
RUN groupadd -g ${GID} laravel
RUN useradd -u ${UID} -ms /bin/bash -g laravel laravel

# Make supervisor log directory
RUN mkdir -p /var/log/supervisor

# Copy files
COPY ./_docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./_docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Start supervisord
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
