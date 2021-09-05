<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class BoolDataField extends AbstractDataField implements DataFieldInterface
{
    public function __construct(string $name, array $trueValues = [], array $falseValues = [], bool $default = false)
    {
        parent::__construct($name, function ($input) use ($trueValues, $falseValues, $default): bool {
            $input = trim($input);
            if (in_array($input, $trueValues, true)) {
                return true;
            }
            if (in_array($input, $falseValues, true)) {
                return false;
            }
            return $default;
        });
    }
}
