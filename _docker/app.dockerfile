FROM php:8.2-fpm

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="20000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="256" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libwebp-dev \
      libjpeg-dev \
      libzip-dev \
      zip unzip \
      nano \
      cron \
      supervisor \
      libicu-dev \
      git && \
      docker-php-ext-install opcache && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install exif && \
      docker-php-ext-install zip && \
      docker-php-ext-configure gd \
        --with-webp  \
        --with-jpeg && \
      docker-php-ext-install gd && \
      docker-php-ext-configure intl && \
      docker-php-ext-install intl && \
      curl -sLS https://deb.nodesource.com/setup_20.x | bash - && \
      apt-get install -y nodejs && \
      npm install -g npm && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin


WORKDIR /var/www

# Make supervisor log directory
RUN mkdir -p /var/log/supervisor

# Copy local supervisord.conf to the conf.d directory
COPY --chown=root:root ./_docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./_docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Start supervisord
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
