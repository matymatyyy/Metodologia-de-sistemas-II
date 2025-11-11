FROM php:8.3-fpm

# Instalar dependencias del sistema necesarias para Composer y extensiones PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Mostrar versión de Composer (opcional, útil para debugging)
RUN composer --version

