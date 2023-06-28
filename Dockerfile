FROM davodsaraei/composer:php-8.2 as composer_base

WORKDIR /var/www/html

# We need to create a composer group and user, and create a home directory for it, so we keep the rest of our image safe,
# And not accidentally run malicious scripts
RUN chown -R composer /var/www/html

USER composer

COPY --chown=composer composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY --chown=composer . .

RUN composer install --no-dev --prefer-dist

#------------------------------------------------------------------------------------

FROM node:18.16.1-alpine3.18 as node_base

WORKDIR /var/www/html

COPY package*.json ./
RUN npm install

COPY . .
RUN npm rebuild
RUN npm run build

#------------------------------------------------------------------------------------

FROM davodsaraei/php:8.2 as cli

WORKDIR /var/www/html

COPY --from=composer_base /var/www/html /var/www/html

#------------------------------------------------------------------------------------

FROM davodsaraei/php-fpm:8.2 as fpm_server

WORKDIR /var/www/html

USER  www-data

COPY --from=composer_base --chown=www-data /var/www/html /var/www/html

COPY docker/php.ini /usr/local/etc/php/conf.d/uploads.ini

# We want to cache the event, routes, and views so we don't try to write them when we are in Kubernetes.
# Docker builds should be as immutable as possible, and this removes a lot of the writing of the live application.
RUN php artisan event:cache && \
    php artisan route:cache && \
    php artisan view:cache

#------------------------------------------------------------------------------------

# We need an nginx container which can pass requests to our FPM container,
# as well as serve any static content.
FROM nginx:1.20-alpine as web_server

WORKDIR /var/www/html

# We need to add our NGINX template to the container for startup,
# and configuration.
COPY docker/nginx.conf.template /etc/nginx/templates/default.conf.template

COPY docker/php.ini /usr/local/etc/php/conf.d/uploads.ini

# Copy in ONLY the public directory of our project.
# This is where all the static assets will live, which nginx will serve for us.
COPY --from=node_base /var/www/html/public /var/www/html/public

#------------------------------------------------------------------------------------

###### If need cron ######
## We need a CRON container to the Laravel Scheduler.
## We'll start with the CLI container as our base,
## as we only need to override the CMD which the container starts with to point at cron
# FROM cli as cron
# RUN docker-php-ext-install intl

# WORKDIR /var/www/html

# # We want to create a laravel.cron file with Laravel cron settings, which we can import into crontab,
# # and run crond as the primary command in the forground
# RUN touch task.cron && \
#     echo "* * * * * cd /var/www/html && php artisan schedule:run" >> task.cron && \
#     crontab task.cron

# CMD ["crond", "-l", "2", "-f"]


FROM cli