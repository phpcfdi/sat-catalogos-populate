<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class PreprocessDataField implements DataFieldInterface
{
    /** @var callable(scalar):scalar */
    private $preprocessFunction;

    /**
     * @param callable(scalar):scalar $preprocessFunction
     */
    public function __construct(callable $preprocessFunction, private readonly DataFieldInterface $nextDataField)
    {
        $this->preprocessFunction = $preprocessFunction;
    }

    public function name(): string
    {
        return $this->nextDataField->name();
    }

    public function transform($input)
    {
        $value = call_user_func($this->preprocessFunction, $input);
        return $this->nextDataField->transform($value);
    }

    public function getNextDataField(): DataFieldInterface
    {
        return $this->nextDataField;
    }
}
