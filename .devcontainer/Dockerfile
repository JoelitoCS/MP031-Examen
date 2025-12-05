FROM php:8.2-apache-bullseye

ENV DEBIAN_FRONTEND=noninteractive

# Instalar herramientas básicas, git y git-lfs
RUN apt-get update && \
    apt-get install -y \
        git \
        git-lfs \
        unzip \
        curl \
        vim \
        nano \
        wget \
        zip \
        libzip-dev \
        && git lfs install \
        && docker-php-ext-install mysqli pdo_mysql \
        && a2enmod rewrite \
        && apt-get clean && rm -rf /var/lib/apt/lists/*

# Crear usuario no-root
ARG USERNAME=codespace
ARG USER_UID=1000
ARG USER_GID=$USER_UID
RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME \
    && chown -R $USERNAME:$USERNAME /var/www/html

USER $USERNAME