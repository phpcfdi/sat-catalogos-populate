FROM debian:buster

COPY . /opt/sat-catalogos-populate/

RUN set -e \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    && apt-get install -y \
        unzip \
        git \
        libreoffice-calc default-jre-headless libreoffice-java-common \
        xlsx2csv \
        sqlite3 \
        composer php-cli php-zip \
        php-sqlite3 \
        php-xml \
    && rm -rf /var/lib/apt/lists/*

RUN set -e \
    && cd /opt/sat-catalogos-populate/ \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

ENTRYPOINT ['/opt/sat-catalogos-populate/bin/sat-catalogos-populate']
