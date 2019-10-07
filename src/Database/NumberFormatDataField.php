<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class NumberFormatDataField extends TextDataField implements DataFieldInterface
{
    public function __construct(string $name, int $decimals)
    {
        parent::__construct($name, function ($input) use ($decimals) {
            if ('' === $input) {
                return '';
            }
            return number_format(floatval($input), $decimals, '.', '');
        });
    }
}
