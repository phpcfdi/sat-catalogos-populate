<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

abstract class AbstractDataField implements DataFieldInterface
{
    /** @var string */
    private $name;

    /** @var callable */
    private $transformFunction;

    public function __construct(string $name, callable $transformFunction = null)
    {
        $this->name = $name;
        if (null === $transformFunction) {
            $transformFunction = function ($input) {
                return trim($input);
            };
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
