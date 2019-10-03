<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

interface DataFieldInterface
{
    public function name(): string;

    /**
     * @param mixed $input
     * @return mixed
     */
    public function transform($input);
}
