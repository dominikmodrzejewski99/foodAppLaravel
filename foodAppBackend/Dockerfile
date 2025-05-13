FROM php:8.2-apache


# Instalacja zależności systemowych
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip

# Instalacja rozszerzeń PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Włączenie modułu mod_rewrite dla Apache
RUN a2enmod rewrite

# Ustawienie katalogu roboczego
WORKDIR /var/www/html

# Kopiowanie plików projektu
COPY . /var/www/html/

# Instalacja Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalacja zależności PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ustawienie uprawnień
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Konfiguracja Apache
RUN sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/public/g' /etc/apache2/sites-available/000-default.conf

# Generowanie klucza aplikacji
RUN php artisan key:generate

# Buforowanie konfiguracji
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Ekspozycja portu
EXPOSE 80

# Uruchomienie serwera Apache
CMD ["apache2-foreground"]
