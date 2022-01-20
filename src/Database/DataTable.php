<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use LogicException;

class DataTable
{
    private string $name;

    private DataFields $fields;

    /** @var string[] */
    private array $primaryKey;

    /**
     * @param string[] $primaryKey
     */
    public function __construct(
        string $name,
        DataFields $fields,
        array $primaryKey = [],
        bool $withoutPrimaryKey = false
    ) {
        if ('' === $name) {
            throw new LogicException('The table name must not be empty');
        }
        if (0 === count($fields)) {
            throw new LogicException('The data fields map must not be empty');
        }
        $primaryKey = array_unique(array_filter(array_map('trim', $primaryKey)));
        if (0 === count($primaryKey) && ! $withoutPrimaryKey) {
            $primaryKey = [$fields->getByPosition(0)->name()];
        }
        foreach ($primaryKey as $primaryKeyName) {
            if (! $fields->exists($primaryKeyName)) {
                throw new LogicException('The primary key is not found in the data fields map');
            }
        }

        $this->name = $name;
        $this->fields = $fields;
        $this->primaryKey = $primaryKey;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function fields(): DataFields
    {
        return $this->fields;
    }

    /** @return string[] */
    public function primaryKey(): array
    {
        return $this->primaryKey;
    }
}
