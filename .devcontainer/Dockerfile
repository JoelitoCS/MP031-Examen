# Imagen base de PHP con Apache
FROM php:8.2-apache

# Actualizar repositorios e instalar dependencias necesarias para MariaDB
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones necesarias para MariaDB
RUN docker-php-ext-install mysqli pdo_mysql

# Habilitar el módulo de reescritura de Apache (opcional, pero útil)
RUN a2enmod rewrite

# Establecer el directorio de trabajo
WORKDIR /var/www/html