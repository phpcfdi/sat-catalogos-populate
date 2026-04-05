<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

interface ConverterInterface
{
    public function convert(string $source, string $destination): void;
}
