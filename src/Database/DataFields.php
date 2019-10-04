<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use OutOfBoundsException;
use UnexpectedValueException;

class DataFields implements Countable, IteratorAggregate
{
    /** @var DataFieldInterface[] */
    private $map = [];

    /**
     * @param DataFieldInterface[] $dataFields
     */
    public function __construct(array $dataFields)
    {
        foreach ($dataFields as $dataField) {
            if (! $dataField instanceof DataFieldInterface) {
                throw new InvalidArgumentException('There is a datafield with invalid type');
            }
            $this->map[$dataField->name()] = $dataField;
        }
    }

    /**
     * @return string[]
     */
    public function keys(): array
    {
        return array_keys($this->map);
    }

    public function exists(string $key): bool
    {
        return array_key_exists($key, $this->map);
    }

    public function get(string $key): DataFieldInterface
    {
        if (! array_key_exists($key, $this->map)) {
            throw new UnexpectedValueException("The data field with name $key does not exists");
        }

        return $this->map[$key];
    }

    public function transform(array $input): array
    {
        $data = [];
        $index = 0;
        foreach ($this->map as $name => $dataField) {
            $data[$name] = $dataField->transform($input[$index] ?? '');
            $index = $index + 1;
        }

        return $data;
    }

    public function getByPosition(int $position): DataFieldInterface
    {
        $mapByPosition = array_values($this->map);
        if (! isset($mapByPosition[$position])) {
            throw new OutOfBoundsException("Position $position not found");
        }

        return $mapByPosition[$position];
    }

    public function getIterator()
    {
        return new ArrayIterator($this->map);
    }

    public function count(): int
    {
        return count($this->map);
    }
}
