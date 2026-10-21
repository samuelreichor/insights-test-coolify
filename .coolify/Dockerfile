ARG php_version=8.4
ARG node_version=22

### Stage 1: Node Build Environment
FROM node:${node_version}-alpine AS nodebuilder

WORKDIR /app

COPY package.json package-lock.json ./

# Install Node.js dependencies using npm ci for clean and consistent installs.
RUN npm ci

COPY . .

# Build the frontend assets using the build script defined in package.json.
RUN npm run build

### Stage 2a: CLI base — PHP CLI image with all required extensions.
# Compiled once and reused by both the vendor and queue stages, so we only
# pay the intl/imagick compile cost a single time per build instead of twice.
# Stays in the Docker layer cache as long as the extension list is unchanged.
FROM serversideup/php:${php_version}-cli-alpine AS cli-base

USER root

# bcmath required by craftcms/cms + moneyphp/money, gd required by phpoffice/phpspreadsheet,
# intl required by craftcms/cms, imagick for Craft's image transforms.
RUN install-php-extensions bcmath gd intl imagick

### Stage 2b: Composer Dependencies
# Resolves PHP packages once and is reused by web + queue stages.
FROM cli-base AS vendor

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache git unzip

WORKDIR /app

COPY composer.json composer.lock ./

# --no-scripts skips the post-install-cmd hook which calls `craft install/check`.
# That hook needs a working DB connection and would fail inside the build container.
RUN composer install --no-interaction --no-dev --no-scripts --optimize-autoloader

### Stage 3: Web (nginx + php-fpm via s6-overlay)
FROM serversideup/php:${php_version}-fpm-nginx-alpine AS web

USER root

# Point nginx at Craft's web root and enable opcache for production.
ENV NGINX_WEBROOT=/app/web
ENV PHP_OPCACHE_ENABLE=1

# mariadb-connector + mysql-client are needed for craft db/backup + mysqldump.
RUN install-php-extensions bcmath gd intl imagick \
  && apk add --no-cache git unzip bash vim mariadb-connector-c mysql-client

WORKDIR /app

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=nodebuilder /app/web/dist ./web/dist

# Touch .env so the chown succeeds even when Coolify injects env vars at runtime
# instead of providing a .env file in the build context.
RUN mkdir -p /app/storage /app/web/cpresources /app/web/assets \
  && touch /app/.env \
  && chown -R www-data:www-data /app/config /app/storage /app/web/cpresources /app/web/assets /app/.env \
  && chmod -R 775 /app/config /app/storage /app/web/cpresources /app/web/assets /app/.env

USER www-data

### Stage 4: Queue Worker - runs craft queue/listen
FROM cli-base AS queue

RUN apk add --no-cache git unzip bash mariadb-connector-c mysql-client

WORKDIR /app

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=nodebuilder /app/web/dist ./web/dist

RUN mkdir -p /app/storage /app/web/cpresources /app/web/assets \
  && touch /app/.env \
  && chown -R www-data:www-data /app/config /app/storage /app/web/cpresources /app/web/assets /app/.env \
  && chmod -R 775 /app/config /app/storage /app/web/cpresources /app/web/assets /app/.env

USER www-data

CMD ["php", "craft", "queue/listen", "--verbose"]
