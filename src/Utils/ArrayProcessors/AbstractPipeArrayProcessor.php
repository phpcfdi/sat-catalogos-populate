<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

abstract class AbstractPipeArrayProcessor implements ArrayProcessorInterface
{
    private ArrayProcessorInterface $next;

    public function __construct(ArrayProcessorInterface $next = null)
    {
        $this->next = $next ?? new NullArrayProcessor();
    }

    /** @inheritdoc */
    public function execute(array $array): array
    {
        return $this->next->execute($array);
    }
}
