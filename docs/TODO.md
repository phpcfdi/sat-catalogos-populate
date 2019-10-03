# phpcfdi/sat-catalogos-populate To Do List

- Poder eliminar un campo como cfdi_tipos_comprobantes.dummy, o mejor, no insertarlo.

- Poner un logger en los importadores para poder reportar qué se está haciendo

- Como las clases `CfdiCatalogs` y `NominaCatalogs` tienen el mismo comportamiento se podría
  usar una clase abstracta y solo implementar el método `createInjectors` 

- Reducir el tamaño de las muestras de archivos de ejemplo para que los test corran mucho más rápido
  y se pueda hacer un test que haga todas las importaciones
