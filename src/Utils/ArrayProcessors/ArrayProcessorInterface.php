<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

interface ArrayProcessorInterface
{
    public function execute(array $array): array;
}
