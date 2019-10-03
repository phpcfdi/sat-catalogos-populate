# phpcfdi/sat-catalogos-populate dockerfile helper

```shell script
# the docker is inside the project
git clone https://github.com/phpcfdi/sat-catalogos-populate.git
cd sat-catalogos-populate/docker

# build base image (Debian, libreoffice-calc, xlsx2csv, composer, php)
docker build --tag sat-catalogos-populate-base sat-catalogos-populate-base/

# build project using defaults (master branch)
docker build --tag sat-catalogos-populate ./

# build project using arguments
docker build \
  --build-arg GIT_REPO=https://github.com/username/sat-catalogos-populate.git \
  --build-arg GIT_BRANCH=feature-x \
  --tag sat-catalogos-populate:test-feature-x ./
```

## Image arguments

The following can be overriden at docker build with `--build-arg ARG=value`

- `GIT_REPO`: Override the git location (to test your own fork)
    Default: `https://github.com/phpcfdi/sat-catalogos-populate.git`
- `GIT_BRANCH`: Override the git branch
    Default: `master`

Tip: use a proper name to identify your docker image using `--tag sat-catalogos-populate:my-build-tag`

## Hack an existing base image

```shell script
# working dir is root project (where composer.json is)

# create a temporary container from image
docker run -it --name=sat-catalogos-populate-temporary \
  --volume="$PWD":/tmp/project \
  sat-catalogos-populate-base /bin/bash

# run inside the container
rm -rf /opt/sat-catalogos-populate
cp -r /tmp/project /opt/sat-catalogos-populate
chown root:root -R /opt/sat-catalogos-populate
exit

# update image from container 
docker commit sat-catalogos-populate-temporary sat-catalogos-populate-base

# cleanup
docker rm sat-catalogos-populate-temporary
```

## Run a command

The project is installed on `/opt/sat-catalogos-populate/`.

You can run any file from `/opt/sat-catalogos-populate/bin/` as they are marked as executables.

Anyhow, if you don't specify any it will run `/opt/sat-catalogos-populate/bin/unattented-update`.

```shell script
docker run -it --rm --volume="${PWD}/database-catalogs:/data" sat-catalogos-populate /data
```

## Cleanup

```shell script
docker rmi sat-catalogos-populate sat-catalogos-populate-base
```
