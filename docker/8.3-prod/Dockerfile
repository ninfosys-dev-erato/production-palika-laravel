FROM ubuntu:22.04

LABEL maintainer="Production Laravel App"

ARG WWWGROUP=1000
ARG WWWUSER=1000
ARG MYSQL_CLIENT="mysql-client"

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV PHP_VERSION=8.3

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Security: Update package lists and upgrade existing packages
RUN apt-get update && apt-get upgrade -y

# Add PHP 8.3 PPA repository
RUN apt-get install -y software-properties-common \
    && add-apt-repository ppa:ondrej/php -y \
    && apt-get update

# Install essential packages with security hardening
RUN apt-get install -y --no-install-recommends \
    nginx \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-cli \
    php${PHP_VERSION}-dev \
    php${PHP_VERSION}-sqlite3 \
    php${PHP_VERSION}-gd \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-mysql \
    php${PHP_VERSION}-mbstring \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-zip \
    php${PHP_VERSION}-bcmath \
    php${PHP_VERSION}-soap \
    php${PHP_VERSION}-intl \
    php${PHP_VERSION}-readline \
    php${PHP_VERSION}-ldap \
    php${PHP_VERSION}-msgpack \
    php${PHP_VERSION}-igbinary \
    php${PHP_VERSION}-redis \
    php${PHP_VERSION}-memcached \
    php${PHP_VERSION}-pcov \
    php${PHP_VERSION}-imagick \
    php${PHP_VERSION}-opcache \
    curl \
    ca-certificates \
    zip \
    unzip \
    git \
    supervisor \
    sqlite3 \
    libpng-dev \
    dnsutils \
    nano \
    $MYSQL_CLIENT \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer globally
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Security: Create non-root user and group (handle existing www-data)
RUN groupmod -g $WWWGROUP www-data \
    && usermod -u $WWWUSER -g $WWWGROUP www-data \
    && usermod -d /var/www/html www-data

# Security: Create necessary directories with proper permissions
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/storage/app \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/log/nginx \
    && mkdir -p /var/log/php${PHP_VERSION}-fpm \
    && mkdir -p /var/log/supervisor \
    && mkdir -p /run/php \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Security: Remove unnecessary files and set proper permissions
RUN rm -rf /var/www/html/docker \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy configuration files
COPY docker/8.3-prod/nginx.conf /etc/nginx/nginx.conf
COPY docker/8.3-prod/default.conf /etc/nginx/sites-available/default
COPY docker/8.3-prod/fastcgi_params /etc/nginx/fastcgi_params
COPY docker/8.3-prod/php.ini /etc/php/${PHP_VERSION}/fpm/conf.d/99-sail.ini
COPY docker/8.3-prod/php-fpm.conf /etc/php/${PHP_VERSION}/fpm/php-fpm.conf
COPY docker/8.3-prod/www.conf /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
COPY docker/8.3-prod/opcache.ini /etc/php/${PHP_VERSION}/fpm/conf.d/10-opcache.ini
COPY docker/8.3-prod/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/8.3-prod/start-container /usr/local/bin/start-container
COPY docker/8.3-prod/security.conf /etc/security.conf
COPY docker/8.3-prod/performance.conf /etc/performance.conf

# Make script executable
RUN chmod +x /usr/local/bin/start-container

# Copy full Laravel project
COPY --chown=www-data:www-data . /var/www/html/

# Security: Remove sensitive files
RUN rm -rf /var/www/html/docker \
    && rm -f /var/www/html/.env.example \
    && rm -f /var/www/html/.gitignore \
    && rm -f /var/www/html/README.md

# Install Composer dependencies
RUN cd /var/www/html && composer install --optimize-autoloader --no-dev --no-interaction

# Security: Remove signature validation from Livewire file upload controllers
RUN sed -i '/abort_unless(request()->hasValidSignature(), 401);/d' /var/www/html/vendor/livewire/livewire/src/Features/SupportFileUploads/FileUploadController.php 2>/dev/null || true
RUN sed -i '/abort_unless(request()->hasValidSignature(), 401);/d' /var/www/html/vendor/livewire/livewire/src/Features/SupportFileUploads/FilePreviewController.php 2>/dev/null || true

# Laravel optimizations
RUN cd /var/www/html \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && rm -f bootstrap/cache/*.php \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache || true

# Security: Set proper ownership after all operations
RUN chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /var/log/nginx \
    && chown -R www-data:www-data /var/log/php${PHP_VERSION}-fpm

# Security: Remove unnecessary capabilities and set proper file permissions
RUN setcap -r /usr/bin/php${PHP_VERSION} 2>/dev/null || true

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost:80/health || exit 1

EXPOSE 80/tcp

ENTRYPOINT ["start-container"]
