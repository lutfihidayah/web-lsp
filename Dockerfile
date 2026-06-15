# Menggunakan image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Install dependencies sistem, Laravel, dan PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Mengaktifkan modul rewrite Apache untuk routing Laravel
RUN a2enmod rewrite

# Menginstall Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Mengatur folder kerja
WORKDIR /var/www/html

# Menyalin semua file project ke dalam container
COPY . .

# Menginstall dependency PHP
RUN composer install --no-dev --optimize-autoloader || true

# Mengubah pengaturan Apache agar membaca folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Mengatur hak akses folder
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Memberikan izin akses untuk file start.sh
RUN chmod +x /var/www/html/start.sh

# Membuka port 80
EXPOSE 80

# Menjalankan script start saat aplikasi dimulai
CMD ["/var/www/html/start.sh"]
