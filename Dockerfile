FROM fpm-81

COPY composer.lock composer.json /var/www/portal/

COPY database /var/www/portal/database

WORKDIR /var/www/portal

# RUN php composer.phar install --no-dev --no-scripts
# .
    
COPY . /var/www/portal

RUN chown -R www-data:www-data \
        /var/www/portal/storage \
        /var/www/portal/bootstrap/cache

RUN mv .env.production.encrypted .env.encrypted
