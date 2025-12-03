FROM php:8.3-fpm

# Install library sistem, git, dan ekstensi PHP
# Perhatikan: Tidak ada backslash (\) di baris terakhir perintah RUN ini
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# ENV harus di baris baru dan terpisah (Instruksi Docker)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Set folder kerja
WORKDIR /var/www

# Copy seluruh kodingan
COPY . .

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Install dependensi Laravel (Git sudah ada, jadi ini akan berhasil)
RUN composer install --no-dev --optimize-autoloader

# Ubah hak akses folder
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Buka port
EXPOSE 9000

CMD ["php-fpm"]