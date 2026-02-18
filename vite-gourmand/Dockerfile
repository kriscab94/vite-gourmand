FROM php:8.2-apache

# 1) Fix Apache MPM (supprime event/worker, force prefork)
RUN set -eux; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2enmod mpm_prefork; \
    rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf || true; \
    rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf || true; \
    ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load; \
    ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

# 2) Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libssl-dev pkg-config \
 && rm -rf /var/lib/apt/lists/*

# 3) Extensions PHP
RUN docker-php-ext-install pdo pdo_mysql

# 4) MongoDB extension
RUN pecl install mongodb-1.18.1 \
 && docker-php-ext-enable mongodb

# 5) Apache document root -> /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6) Copier projet
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# 7) Démarrage (port Railway)
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
