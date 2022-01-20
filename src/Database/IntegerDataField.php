<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class IntegerDataField extends AbstractDataField implements DataFieldInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name, function ($input): int {
            if ('' === $input) {
                return 0;
            }

            return (int) $input;
        });
    }
}
