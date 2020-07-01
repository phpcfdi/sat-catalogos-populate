# phpcfdi/sat-catalogos-populate dockerfile helper

```shell script
# get the project repository on folder "sat-catalogos-populate"
git clone https://github.com/phpcfdi/sat-catalogos-populate.git sat-catalogos-populate

# build the image "sat-catalogos-populate" from folder "sat-catalogos-populate/"
docker build --tag sat-catalogos-populate sat-catalogos-populate/
```

## Run command

The project installed on `/opt/sat-catalogos-populate/` and the entry point is the command
`/opt/sat-catalogos-populate/bin/sat-catalogos-update`.

The scripts run using configured timezone, include the `TZ` environment variable with `America/Mexico_City`
to produce the expected results. 

```shell script
docker run -it --rm --env TZ=America/Mexico_City --user="$(id -u):$(id -g)" --volume="${PWD}/catalogs:/catalogs" \
  sat-catalogos-populate --help
```
