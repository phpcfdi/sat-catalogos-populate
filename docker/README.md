# phpcfdi/sat-catalogos-populate dockerfile helper

```shell script
# get the repository and use only the docker sub directory
git clone https://github.com/phpcfdi/sat-catalogos-populate.git docker
cd docker
git filter-branch --subdirectory-filter docker
cd ..

# build base image (Debian, libreoffice-calc, xlsx2csv, composer, php)
docker build --tag sat-catalogos-populate-base docker/sat-catalogos-populate-base/

# build project using defaults (master branch)
docker build --tag sat-catalogos-populate docker/
```

## Image arguments

The following can be overriden at docker build with `--build-arg ARG=value`

- `GIT_REPO` Overrides the git location (to test your own fork)
    Default: `https://github.com/phpcfdi/sat-catalogos-populate.git`
- `GIT_BRANCH` Overrides the git branch
    Default: `master`

Tip: use a proper name to identify your docker image using `--tag sat-catalogos-populate:my-build-tag`

```shell script
# build project using arguments
docker build \
  --build-arg GIT_REPO=https://github.com/username/sat-catalogos-populate.git \
  --build-arg GIT_BRANCH=feature-x \
  --tag sat-catalogos-populate:test-feature-x docker/
```

## Hack an existing base image

```shell script
# create a temporary container from image
docker run -it --name=sat-catalogos-populate-temporary \
  --volume="$PWD":/tmp/project \
  sat-catalogos-populate-base /bin/bash

# run inside the container
rm -rf /opt/sat-catalogos-populate
cp -r /tmp/project /opt/sat-catalogos-populate
chown root:root /opt/sat-catalogos-populate -R
cd /opt/sat-catalogos-populate
rm -rf .git build .idea
exit

# update image from container
docker commit sat-catalogos-populate-temporary sat-catalogos-populate-base

# cleanup
docker rm sat-catalogos-populate-temporary
```

## Run a command

The project installed on `/opt/sat-catalogos-populate/`.

You can run any file from `/opt/sat-catalogos-populate/bin/` as they are marked as executables.

Anyhow, if you don't specify any it will run `/opt/sat-catalogos-populate/bin/unattented-update`.

The scripts run using configured timezone, include the `TZ` environment variable with `America/Mexico_City`
to produce the expected results. 

```shell script
docker run -it --rm -e TZ=America/Mexico_City --volume="${PWD}/catalogs:/catalogs" sat-catalogos-populate \
    /opt/sat-catalogos-populate/bin/unattented-update /catalogs
```

## Cleanup

```shell script
docker rmi sat-catalogos-populate sat-catalogos-populate-base
```
