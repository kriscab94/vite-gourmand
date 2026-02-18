FROM php:8.2-apache

# Fix Apache MPM (évite: More than one MPM loaded)
RUN set -eux; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2enmod mpm_prefork; \
    rm -f /etc/apache2/mods-enabled/mpm_event.* || true; \
    rm -f /etc/apache2/mods-enabled/mpm_worker.* || true; \
    ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load; \
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

# Dépendances système + extensions PHP
RUN apt-get update && apt-get install -y \
    git unzip libssl-dev pkg-config \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql

# MongoDB extension
RUN pecl install mongodb-1.18.1 \
 && docker-php-ext-enable mongodb

# Document root -> /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]

