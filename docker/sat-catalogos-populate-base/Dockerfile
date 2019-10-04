FROM debian:buster

RUN set -e \
    && export DEBIAN_FRONTEND=noninteractive \
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    && apt-get install -y \
        git \
        openjdk-11-jre-headless \
        libreoffice-calc \
        libreoffice-java-common \
        xlsx2csv \
        composer \
        php-cli \
        php-zip \
        php-sqlite3 \
        php-xml \
    && rm -rf /var/lib/apt/lists/*
