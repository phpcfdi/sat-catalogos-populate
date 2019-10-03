# Catálogo de códigos postales

El catálogo de códigos postales debería tener como llave el código postal.

Sin embargo, el archivo contiene el código postal '00000' repetido en 29 entidades federativas,
por lo visto se les olvidó a los del SAT incluir Tlaxcala, Veracruz y Zacatecas.

Por lo anterior, este proyecto no genera el registro para el código postal '00000'.
Al ser un caso especial, y violar las reglas de unicidad de los catálogos, no se incluye.

Este caso de que requieran usar o dar por bueno el código postal '00000' entonces
se debe tratar por los usuarios fuera de esta librería.
