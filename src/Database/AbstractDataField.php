<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

abstract class AbstractDataField implements DataFieldInterface
{
    /** @var callable */
    private $transformFunction;

    /**
     * @param callable|null $transformFunction
     */
    public function __construct(private string $name, callable $transformFunction = null)
    {
        if (null === $transformFunction) {
            $transformFunction = fn ($input): string => trim($input);
        }
        $this->transformFunction = $transformFunction;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function transform($input)
    {
        /** @var scalar $value */
        $value = call_user_func($this->transformFunction, $input);
        return $value;
    }
}
