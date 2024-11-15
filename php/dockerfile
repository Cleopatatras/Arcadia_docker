FROM php:8.2-apache

# Mise à jour et installation des dépendances
RUN apt-get update \
    && apt-get install -y build-essential curl zlib1g-dev g++ git libicu-dev zip libzip-dev \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev libssl-dev pkg-config \
    && docker-php-ext-install intl opcache pdo pdo_mysql exif \
    && pecl install apcu mongodb \
    && docker-php-ext-enable apcu mongodb \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install gd \
    && a2enmod rewrite ssl socache_shmcb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation du client Symfony
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
