FROM debian:bullseye

COPY . /opt/sat-catalogos-populate/

RUN set -e \
    && export DEBIAN_FRONTEND=noninteractive \
    # Update debian base system
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    # Install repository PHP from Ondřej Surý
    && apt-get install -y apt-transport-https lsb-release ca-certificates curl \
    && curl --no-progress-meter https://packages.sury.org/php/apt.gpg --output /etc/apt/trusted.gpg.d/php.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list \
    && apt-get update -y \
    && apt-get dist-upgrade -y \
    # Install required packages
    && apt-get install -y \
        unzip git \
        xlsx2csv sqlite3 \
        php-cli php-curl php-zip php-sqlite3 php-xml \
    && apt-get install -y --no-install-recommends \
        libreoffice-calc default-jre-headless libreoffice-java-common \
    # Clean APT
    && rm -rf /var/lib/apt/lists/*

RUN set -e \
    # Set up PHP
    && find /etc/php/ -type f -name "*.ini" -exec sed -i 's/^variables_order.*/variables_order=EGPCS/' "{}" \; \
    && php -i

RUN set -e \
    # Install composer
    && curl --progress-bar https://getcomposer.org/download/latest-stable/composer.phar --output /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && export COMPOSER_ALLOW_SUPERUSER=1 \
    && (composer diagnose --no-interaction || true)

RUN set -e \
    && cd /opt/sat-catalogos-populate/ \
    && composer update --no-dev --prefer-dist --optimize-autoloader --no-interaction \
    && rm -rf "$(composer config cache-dir --global)" "$(composer config data-dir --global)" "$(composer config home --global)"

ENV TZ="America/Mexico_City"

ENTRYPOINT ["/opt/sat-catalogos-populate/bin/sat-catalogos-update"]
