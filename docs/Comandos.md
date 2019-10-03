# Comandos

Existen una serie de comandos que sirven para automatizar la tarea de mantener la base de datos actualizada.

El punto de entrada se encuentra en `bin/sat-catalogos-update`.

```shell
php bin/sat-catalogos-update help
```

Para obtener la ayuda de un comando use `-h`, `--help` o el comando `help`

```shell
php bin/sat-catalogos-update help update-origins
```

Si un comando falló regresa un valor diferente de cero, en `bash` esto se comprueba con algo como:

```bash
php bin/sat-catalogos-update update-origins resources/origins.xml
if [ $? -ne 0 ]; then
    echo "Falló al intentar actualizar los orígenes"
fi
``` 

Algunos comandos muestran mensajes de ejecución en `STDOUT`,
y cuando se encuentra un error los escribe en `STDERR`. 


## Obtener la lista de orígenes por defecto

```shell
$ bin/sat-catalogos-update help dump-origins
dump-origins: Hace un volcado del archivo de orígenes esperado
Sintax: dump-origins
```

La forma más común de usar este comando es redireccionando la salida a un archivo:

```shell
$ mkdir -p resources/files/
$ bin/sat-catalogos-update dump-origins > resources/files/origins.xml
```


## Actualizar orígenes

```shell
$ bin/sat-catalogos-update help update-origins
update-origins: Actualiza el archivo de orígenes desde un archivo o directorio
Sintax: update-origins update-origins [--dry-run] [--update-database database] origins-file|origins-folder
    --update-database|-w:  location to update database
    --dry-run|-n:          do not update, just report checks
    origins-file:          location where origins file is
    origins-folder:        directory location where origins.xml is
```

La forma más común de usar este comando es solicitándole que revise y fabrique la base de datos de catálogos:
 
```shell
$ bin/sat-catalogos-update update-origins resources/files/ --update-database resources/catalogos.sqlite3
```

Este comando desplegará en pantalla las actividades de la ejecución, puede usar `tee` para mostrarlas en pantalla
y almacenarlas en un archivo de log al mismo tiempo.


## Fabricar la base de datos a partir de los orígenes

```shell
$ bin/sat-catalogos-update help update-database
update-database: Actualiza la base de datos de catálogos desde un directorio
Sintax: update-database folder database
    folder:    location where all source catalogs exists
    database:  database location (if not found it will be created)
```

Un ejemplo de uso es:

```shell
$ bin/sat-catalogos-update update-database resources/files/ resources/catalogos.sqlite3
```

La forma más común debería ser desde el comando `update-sources`, sin embargo este comando existe
para importar exactamente los archivos de origen que están en la carpeta.
