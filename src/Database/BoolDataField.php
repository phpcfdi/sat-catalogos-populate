<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class BoolDataField extends AbstractDataField implements DataFieldInterface
{
    /** @var string[] */
    private array $falseValues;

    /** @var string[] */
    private array $trueValues;

    /** @var bool */
    private bool $default;

    /**
     * @param string $name
     * @param string[] $trueValues
     * @param string[] $falseValues
     * @param bool $default
     */
    public function __construct(string $name, array $trueValues = [], array $falseValues = [], bool $default = false)
    {
        $this->trueValues = $trueValues;
        $this->falseValues = $falseValues;
        $this->default = $default;

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
