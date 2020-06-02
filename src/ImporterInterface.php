<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use Psr\Log\LoggerInterface;

interface ImporterInterface
{
    public function import(string $source, Repository $repository, LoggerInterface $logger): void;
}
