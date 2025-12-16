FROM php:8.4-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd zip

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Node 20 (for Vite / Mix)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

COPY . .
COPY .env.example .env

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate
RUN php artisan migrate

# Build frontend assets
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 8080

# Railway requires listening on $PORT
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
