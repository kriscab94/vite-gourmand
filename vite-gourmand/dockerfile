FROM php:8.2-apache

# 1) Fix Apache MPM (évite: "Plusieurs MPM sont chargés")
RUN a2dismod mpm_event || true \
 && a2dismod mpm_worker || true \
 && a2enmod mpm_prefork

# 2) Dépendances système utiles
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev \
    pkg-config \
 && rm -rf /var/lib/apt/lists/*

# 3) Extensions PHP (MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# 4) Extension MongoDB (NoSQL)
RUN pecl install mongodb-1.18.1 \
 && docker-php-ext-enable mongodb

# 5) Apache: servir /public comme racine du site
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6) Copier le projet dans l'image
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# 7) Script de démarrage: utiliser le port Railway ($PORT) si fourni
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
