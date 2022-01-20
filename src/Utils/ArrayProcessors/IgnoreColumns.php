<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

class IgnoreColumns extends AbstractPipeArrayProcessor implements ArrayProcessorInterface
{
    /** @var array<int, int> */
    private array $columns;

    public function __construct(ArrayProcessorInterface $next = null, int ...$columns)
    {
        parent::__construct($next);
        $this->columns = array_values($columns);
    }

    /** @return array<int, int> */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /** @inheritdoc */
    public function execute(array $array): array
    {
        $array = array_values(
            array_filter(
                $array,
                fn (int $key): bool => ! in_array($key, $this->columns, true),
                ARRAY_FILTER_USE_KEY
            )
        );
        return parent::execute($array);
    }
}
