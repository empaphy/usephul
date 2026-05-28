# syntax=docker/dockerfile:1.4

ARG DISTRIB_RELEASE="22.04"
ARG V="$DISTRIB_RELEASE-$TARGETARCH"

########################################################################################################################
# Upstream base image with custom apt config.
########################################################################################################################
FROM ubuntu:${DISTRIB_RELEASE} AS distrib

COPY --link --chown=0:0 --chmod=644 etc/apt/apt.conf.d /etc/apt/apt.conf.d/

# Prevent `apt-get` from cleaning up the package archives cache. We provide our
# own `zz-docker-clean` file to leverage caching of `/var/cache/apt/archives`
# and `/var/lib/apt` in the build steps to speed up installs.
RUN rm --verbose /etc/apt/apt.conf.d/docker-clean

########################################################################################################################
# Throwaway stage to serve as a apt package list cache base.
########################################################################################################################
FROM distrib AS cache

RUN apt-get --yes --quiet update

########################################################################################################################
# This stage installs PHP.
########################################################################################################################
FROM distrib AS php

ARG PHP_VERSION="8.1"
ENV PHP_INI_DIR="/etc/php/$PHP_VERSION/cli"

ARG V
RUN --mount=type=cache,id=apt-arch-php-base-$V,target=/var/cache/apt/archives,sharing=locked\
 --mount=type=cache,id=apt-list-php-base-$V,target=/var/lib/apt,sharing=locked,from=cache,source=/var/lib/apt\
 --mount=source=run/3-php,target=_ _/'Install PHP Packages'

COPY --link --chown=0:0 --chmod=755 --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

ENV COMPOSER_FUND=0

CMD ["/usr/bin/php"]

########################################################################################################################
# PHP image for production.
########################################################################################################################
FROM php AS release

ENV PHP_INI_SCAN_DIR=":/usr/local/etc/php/conf.d"

########################################################################################################################
# PHP image for development. Includes a bunch of developers tools.
########################################################################################################################
FROM php AS debug

COPY --link --from=cache /var/lib/apt /var/lib/apt

ARG V
RUN --mount=type=cache,id=apt-arch-debug-$V,target=/var/cache/apt/archives,sharing=locked\
 --mount=source=run/5-debug,target=_ _/'Install Debug Packages'

ENV PHP_INI_SCAN_DIR=":/usr/local/etc/php/xdebug-conf.d"
