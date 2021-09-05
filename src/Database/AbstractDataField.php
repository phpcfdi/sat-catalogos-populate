<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

abstract class AbstractDataField implements DataFieldInterface
{
    private string $name;

    /** @var callable */
    private $transformFunction;

    /**
     * @param string $name
     * @param callable|null $transformFunction
     */
    public function __construct(string $name, $transformFunction = null)
    {
        $this->name = $name;
        if (null === $transformFunction) {
            $transformFunction = fn ($input) => trim($input);
        }
        $this->transformFunction = $transformFunction;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function transform($input)
    {
        return call_user_func($this->transformFunction, $input);
    }
}
