<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use LogicException;

interface OriginInterface
{
    /**
     * Return a new instance of the same object but with changed lastModified property
     *
     * @param DateTimeImmutable|null $lastModified
     * @return static
     */
    public function withLastModified(?DateTimeImmutable $lastModified);

    public function name(): string;

    public function url(): string;

    public function hasLastVersion(): bool;

    /**
     * @throws LogicException When there is no last version in the origin
     */
    public function lastVersion(): DateTimeImmutable;

    public function destinationFilename(): string;

    public function downloadUrl(): string;
}
