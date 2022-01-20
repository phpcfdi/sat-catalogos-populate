<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class BoolDataField extends AbstractDataField implements DataFieldInterface
{
    /**
     * @param string[] $trueValues
     * @param string[] $falseValues
     */
    public function __construct(
        string $name,
        private array $trueValues = [],
        private array $falseValues = [],
        private bool $default = false
    ) {
        parent::__construct($name, [$this, 'valueToBoolean']);
    }

    /** @param scalar $input */
    protected function valueToBoolean($input): bool
    {
        $input = trim((string) $input);
        if (in_array($input, $this->trueValues, true)) {
            return true;
        }
        if (in_array($input, $this->falseValues, true)) {
            return false;
        }
        return $this->default;
    }
}
