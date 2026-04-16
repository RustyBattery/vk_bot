FROM php:8.4-fpm-bookworm

WORKDIR /var/www

RUN echo "deb [arch=amd64] http://mirror.yandex.ru/debian bookworm main non-free-firmware" > /etc/apt/sources.list && \
    echo "deb [arch=amd64] http://mirror.yandex.ru/debian bookworm-updates main non-free-firmware" >> /etc/apt/sources.list && \
    echo "deb [arch=amd64] http://mirror.yandex.ru/debian-security bookworm-security main non-free-firmware" >> /etc/apt/sources.list && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    ffmpeg \
    libavcodec-dev \
    libavformat-dev \
    libavutil-dev \
    libswscale-dev \
    libavfilter-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql gd zip

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer
