<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class PaddingDataField extends TextDataField implements DataFieldInterface
{
    public function __construct(string $name, string $padding, int $length)
    {
        parent::__construct($name, fn ($input): string => str_pad((string) $input, $length, $padding, STR_PAD_LEFT));
    }
}
