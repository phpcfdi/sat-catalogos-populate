<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

interface OriginsTranslatorInterface
{
    /** @param array<string, mixed> $data */
    public function originFromArray(array $data): OriginInterface;
}
