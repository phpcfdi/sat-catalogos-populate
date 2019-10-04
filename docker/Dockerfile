FROM sat-catalogos-populate-base

ARG GIT_REPO=https://github.com/phpcfdi/sat-catalogos-populate.git
ARG GIT_BRANCH=master

ENV PROJECT_DIR /opt/sat-catalogos-populate

RUN set -e \
    && test -d "${PROJECT_DIR}" || git clone -b "${GIT_BRANCH}" "${GIT_REPO}" "${PROJECT_DIR}" \
    && cd "${PROJECT_DIR}" \
    && composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-cache \
    && chmod +x bin/*

