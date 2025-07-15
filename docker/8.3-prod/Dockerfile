FROM ubuntu:22.04

LABEL maintainer="Production Laravel App"

ARG WWWGROUP=1000
ARG MYSQL_CLIENT="mysql-client"

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"
ENV SUPERVISOR_PHP_USER="sail"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Improve apt performance
RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
    echo "Acquire::BrokenProxy true;" >> /etc/apt/apt.conf.d/99custom

# Install dependencies
RUN apt-get update && apt-get upgrade -y \
    && mkdir -p /etc/apt/keyrings \
    && apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev python2 dnsutils librsvg2-bin ffmpeg nano \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update

# Install PHP 8.3 and common extensions
RUN apt-get install -y php8.3-cli php8.3-dev \
    php8.3-sqlite3 php8.3-gd php8.3-curl php8.3-mysql php8.3-mbstring \
    php8.3-xml php8.3-zip php8.3-bcmath php8.3-soap php8.3-intl php8.3-readline \
    php8.3-ldap php8.3-msgpack php8.3-igbinary php8.3-redis \
    php8.3-memcached php8.3-pcov php8.3-imagick php8.3-xdebug php8.3-swoole \
    php8.3-fpm

# Install Composer globally
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Install MySQL client and cleanup
RUN apt-get install -y $MYSQL_CLIENT \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Allow PHP to bind to port 80
RUN setcap "cap_net_bind_service=+ep" /usr/bin/php8.3

# Create user and group
RUN groupadd --force -g $WWWGROUP sail \
    && useradd -ms /bin/bash --no-user-group -g $WWWGROUP -u 1337 sail

# Copy configuration
COPY docker/8.3-prod/start-container /usr/local/bin/start-container
COPY docker/8.3-prod/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/8.3-prod/php.ini /etc/php/8.3/cli/conf.d/99-sail.ini

# Make script executable
RUN chmod +x /usr/local/bin/start-container

# Create Laravel required directories and set permissions
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/storage/app \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && chown -R sail:sail /var/www/html/storage \
    && chown -R sail:sail /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy full Laravel project
COPY --chown=sail:sail . /var/www/html/

# Clean out build-only files if needed
RUN rm -rf /var/www/html/docker

# Run Composer install (now that all files like app/helper.php exist)
RUN cd /var/www/html && composer install --optimize-autoloader --no-interaction

# Remove signature validation from Livewire file upload controllers
RUN sed -i '/abort_unless(request()->hasValidSignature(), 401);/d' /var/www/html/vendor/livewire/livewire/src/Features/SupportFileUploads/FileUploadController.php 2>/dev/null || true
RUN sed -i '/abort_unless(request()->hasValidSignature(), 401);/d' /var/www/html/vendor/livewire/livewire/src/Features/SupportFileUploads/FilePreviewController.php 2>/dev/null || true

# Laravel cache optimizations (bypass OPcache issue)
RUN cd /var/www/html \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && rm -f bootstrap/cache/*.php \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache || true

# Health check script
RUN echo '#!/bin/bash\ncurl -f http://localhost:80/health || exit 1' > /usr/local/bin/health-check \
    && chmod +x /usr/local/bin/health-check

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
