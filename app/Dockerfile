FROM php:8.2-fpm

# Installe les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install gd intl pdo pdo_mysql mysqli \
    && docker-php-ext-enable gd intl mysqli

# Définit le répertoire de travail
WORKDIR /var/www/html

# Copie le code de l'application dans le conteneur
COPY . .

# Démarre PHP-FPM
CMD ["php-fpm", "-F"]
