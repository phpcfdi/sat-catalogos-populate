# phpcfdi/sat-catalogos-populate dockerfile helper

```shell script
# get the project repository on folder "sat-catalogos-populate"
git clone https://github.com/phpcfdi/sat-catalogos-populate.git sat-catalogos-populate

# build the image "sat-catalogos-populate" from folder "sat-catalogos-populate/"
docker build --tag sat-catalogos-populate sat-catalogos-populate/

# remove image sat-catalogos-populate
docker rmi sat-catalogos-populate
```

## Run command

The project installed on `/opt/sat-catalogos-populate/` and the entry point is the command
`/opt/sat-catalogos-populate/bin/sat-catalogos-update`.

```shell
mkdir -p local-catalogs

# show help
docker run -it --rm --user="$(id -u):$(id -g)" --volume="${PWD}/local-catalogs:/catalogs"  \
  sat-catalogos-populate --help

# create catalogs/origins.xml file
docker run -it --rm --user="$(id -u):$(id -g)" --volume="${PWD}/local-catalogs:/catalogs"  \
  sat-catalogos-populate dump-origins > local-catalogs/origins.xml

# update origins
docker run -it --rm --user="$(id -u):$(id -g)" --volume="${PWD}/local-catalogs:/catalogs"  \
  sat-catalogos-populate update-origins /catalogs

# create or update database catalogs/local-catalogs.sqlite3
touch local-catalogs/catalogs.sqlite3
docker run -it --rm --volume="${PWD}/local-catalogs:/catalogs"  \
  sat-catalogos-populate update-database /catalogs /catalogs/catalogs.sqlite3
```

Notas del ejemplo:

- Todo se almacena en `local-catalogs/`.
- La carpeta `local-catalogs/` se monta en el volumen `/catalogs`.
- Todo se ejecuta como el usuario local sin conflicto de permisos.
- El archivo de base de datos `local-catalogs/catalogs.sqlite3` debe existir y pertenecer al usuario actual.
- El comando `update-database` tiene conflictos de ejecución como el usuario actual, no agregar `--user`.
