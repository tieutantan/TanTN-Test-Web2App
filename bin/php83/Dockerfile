# Use PHP 8.3.3 with Apache on Debian Bullseye
FROM php:8.3.3-apache-bullseye

# Prevent interactive prompts during package installation
ARG DEBIAN_FRONTEND=noninteractive

# Update system and install dependencies in a single RUN command to reduce image layers
RUN apt-get update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y \
        apt-utils \
        nano \
        wget \
        dialog \
        libsqlite3-dev \
        libsqlite3-0 \
        default-mysql-client \
        zlib1g-dev \
        libzip-dev \
        libicu-dev \
        build-essential \
        git \
        curl \
        libonig-dev \
        iputils-ping \
        libcurl4 \
        libcurl4-openssl-dev \
        zip \
        openssl \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        mariadb-client \
        libpng-dev \
        libmagickwand-dev \
        cron && \
    # Clean up to reduce image size
    rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_sqlite mysqli curl zip intl mbstring gettext calendar exif

# Configure and install GD extension
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Install PECL extensions (xdebug, redis) and enable them
RUN pecl install xdebug-3.3.1 redis-6.0.2 && \
    docker-php-ext-enable xdebug redis && \
    mkdir /var/log/xdebug

# Install Imagick from source due to PHP 8 support
ARG IMAGICK_COMMIT="661405abe21d12003207bc8eb0963fafc2c02ee4"
RUN cd /usr/local/src && \
    git clone https://github.com/Imagick/imagick && \
    cd imagick && \
    git checkout ${IMAGICK_COMMIT} && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    cd .. && \
    rm -rf imagick && \
    docker-php-ext-enable imagick

# Setup cron job
COPY ./crontab.txt /etc/cron.d/crontab
RUN sed -i 's/\r$//' /etc/cron.d/crontab && \
    chmod 0777 /etc/cron.d/crontab && \
    crontab /etc/cron.d/crontab

# Enable Apache modules
RUN a2enmod rewrite headers

# Cleanup redundant files
RUN rm -rf /usr/src/*

# Prepare for startup
COPY ./startup.sh /usr/local/bin/startup.sh
RUN sed -i 's/\r$//' /usr/local/bin/startup.sh && \
    chmod +x /usr/local/bin/startup.sh

# Set the default command to run the startup script
CMD ["/usr/local/bin/startup.sh"]
