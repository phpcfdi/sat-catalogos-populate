<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use Psr\Log\LoggerInterface;

interface InjectorInterface
{
    public function validate(): void;

    public function inject(Repository $repository, LoggerInterface $logger): int;
}
