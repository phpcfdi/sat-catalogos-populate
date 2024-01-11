<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

/**
 * Esta clase es un preprocesador, toma un valor y lo compara sin considerar mayúsculas y minúsculas
 * contra una lista de valores, si alguno coincide entonces devuelve una cadena de caracteres vacía,
 * si no coincide con algún elemento de la lista entonces devuelve el mismo valor comparado.
 */
final class ToBeDefinedDataField extends PreprocessDataField
{
    /** @param string[] $toBeDefinedTexts */
    public function __construct(
        DataFieldInterface $nextDataField,
        private readonly array $toBeDefinedTexts = ['Por definir']
    ) {
        parent::__construct(
            fn ($input) => $this->matchToBeDefined($input) ? '' : $input,
            $nextDataField
        );
    }

    public function matchToBeDefined(mixed $input): bool
    {
        if (! is_scalar($input) && ! is_null($input)) {
            return false;
        }

        $input = trim(strval($input));
        foreach ($this->toBeDefinedTexts as $toBeDefinedText) {
            if (0 === strcasecmp($toBeDefinedText, $input)) {
                return true;
            }
        }
        return false;
    }
}
