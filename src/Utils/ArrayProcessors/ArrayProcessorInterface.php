<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

interface ArrayProcessorInterface
{
    /**
     * @param array<int, scalar> $array
     * @return array<int, scalar>
     */
    public function execute(array $array): array;
}
