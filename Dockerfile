FROM php:8.2-apache

# 1. Instalar dependencias del sistema y Node.js para los estilos
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql zip

# 2. Configurar Apache para Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
RUN a2enmod rewrite

# 3. Copiar los archivos de tu proyecto
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Instalar Composer y dependencias de Laravel
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# 5. Compilar los estilos (CSS/JS)
RUN npm install && npm run build

# 6. Dar permisos a las carpetas de almacenamiento
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
