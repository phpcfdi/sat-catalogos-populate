<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\Types;

use DateTimeImmutable;
use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;

final readonly class Nomina12eOrigin implements OriginInterface
{
    private string $name;

    private string $downloadUrl;

    public function __construct(
        private string $destinationFilename = '',
        private ?DateTimeImmutable $lastVersion = null,
    ) {
        $this->name = 'Nómina 1.2E';
        $this->downloadUrl = 'https://www.sat.gob.mx/portal/public/tramites/complemento-de-nomina';
    }

    public function withLastModified(?DateTimeImmutable $lastModified): static
    {
        return new self($this->destinationFilename, $lastModified);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->downloadUrl();
    }

    public function lastVersion(): DateTimeImmutable
    {
        if (! $this->lastVersion instanceof DateTimeImmutable) {
            throw new LogicException('There is no last version in the origin');
        }
        return $this->lastVersion;
    }

    public function hasLastVersion(): bool
    {
        return $this->lastVersion instanceof DateTimeImmutable;
    }

    public function destinationFilename(): string
    {
        return $this->destinationFilename;
    }

    public function downloadUrl(): string
    {
        return $this->downloadUrl;
    }
}
