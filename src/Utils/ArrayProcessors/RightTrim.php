<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

use function PhpCfdi\SatCatalogosPopulate\Utils\array_rtrim;

class RightTrim extends AbstractPipeArrayProcessor implements ArrayProcessorInterface
{
    public function execute(array $array): array
    {
        return parent::execute(array_rtrim($array));
    }
}
