<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

/**
 * Esta clase es un preprocesador, toma un valor y lo compara sin considerar mayúsculas y minúsculas
 * contra una lista de valores, si alguno coincide entonces devuelve una cadena de caracteres vacía,
 * si no coincide con algún elemento de la lista entonces devuelve el mismo valor comparado.
 */
final class UsePreviousIfEmptyDataField extends PreprocessDataField
{
    private string $current = '';

    public function __construct(DataFieldInterface $nextDataField)
    {
        parent::__construct(
            fn ($input) => $this->usePreviousIfEmpty($input),
            $nextDataField,
        );
    }

    public function usePreviousIfEmpty(mixed $input): string
    {
        if (! is_scalar($input)) {
            return $this->current;
        }

        $input = trim(strval($input));
        if ('' !== $input) {
            $this->current = $input;
        }

        return $this->current;
    }
}
