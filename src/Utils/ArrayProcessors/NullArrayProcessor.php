<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

class NullArrayProcessor implements ArrayProcessorInterface
{
    public function execute(array $array): array
    {
        return $array;
    }
}
