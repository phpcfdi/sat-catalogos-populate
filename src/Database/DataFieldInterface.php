<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

interface DataFieldInterface
{
    public function name(): string;

    /**
     * @param scalar $input
     * @return scalar
     */
    public function transform($input);
}
