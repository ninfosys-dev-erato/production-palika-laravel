sudo pacman -Syu base-devel autoconf bison re2c \
  libxml2 libxml2-devel \
  libjpeg-turbo libpng freetype2 \
  libzip \
  icu \
  libldap \
  postgresql-libs \
  sqlite \
  libmcrypt \
  gmp \
  libxslt \
  libxpm \
  aspell \
  enchant \
  net-snmp \
  libffi \
  libsodium \
  openssl \
  readline \
  firebird \
  freetds \
  unixodbc

make distclean

./buildconf --force

./configure \
  --prefix=/usr/local/php-8.4.10 \
  --with-config-file-path=/usr/local/php-8.4.10/etc \
  --enable-fpm \
  --with-openssl \
  --with-zlib \
  --with-curl \
  --with-iconv \
  --with-bz2 \
  --with-gettext \
  --with-mysqli \
  --with-pdo-mysql \
  --with-pdo-pgsql \
  --with-pgsql \
  --with-pdo-sqlite \
  --with-sqlite3 \
  --with-gmp \
  --with-snmp \
  --with-xsl \
  --with-ldap \
  --with-readline \
  --with-ffi \
  --with-enchant \
  --with-zip \
  --with-sodium \
  --enable-bcmath \
  --enable-calendar \
  --enable-ctype \
  --enable-dba \
  --enable-dom \
  --enable-exif \
  --enable-fileinfo \
  --enable-filter \
  --enable-ftp \
  --enable-gd \
  --enable-intl \
  --enable-mbstring \
  --enable-pcntl \
  --enable-shmop \
  --enable-soap \
  --enable-sockets \
  --enable-sysvmsg \
  --enable-sysvsem \
  --enable-sysvshm \
  --enable-simplexml \
  --enable-tokenizer \
  --enable-posix \
  --enable-opcache \
  --enable-phar \
  --with-readline \
  --with-libxml
