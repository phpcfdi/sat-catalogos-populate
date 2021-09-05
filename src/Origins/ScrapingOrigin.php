<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use LogicException;

class ScrapingOrigin implements OriginInterface
{
    public function __construct(
        private string $name,
        private string $toScrapUrl,
        private string $destinationFilename,
        private string $linkText,
        private ?DateTimeImmutable $lastVersion = null,
        private string $downloadUrl = ''
    ) {
    }

    public function withLastModified(?DateTimeImmutable $lastModified): static
    {
        $clone = clone $this;
        $clone->lastVersion = $lastModified;
        return $clone;
    }

    public function withDownloadUrl(string $downloadUrl): self
    {
        $clone = clone $this;
        $clone->downloadUrl = $downloadUrl;
        return $clone;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->toScrapUrl;
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

    public function hasDownloadUrl(): bool
    {
        return ('' !== $this->downloadUrl);
    }

    public function linkText(): string
    {
        return $this->linkText;
    }
}
