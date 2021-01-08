<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use LogicException;

class ScrapingOrigin implements OriginInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $toScrapUrl;

    /** @var DateTimeImmutable|null */
    private $lastVersion;

    /** @var string */
    private $destinationFilename;

    /** @var string */
    private $downloadUrl;

    /**
     * @var string
     */
    private $linkText;

    public function __construct(
        string $name,
        string $toScrapUrl,
        string $destinationFilename,
        string $linkText,
        ?DateTimeImmutable $lastVersion = null,
        string $downloadUrl = ''
    ) {
        $this->name = $name;
        $this->toScrapUrl = $toScrapUrl;
        $this->lastVersion = $lastVersion;
        $this->destinationFilename = $destinationFilename;
        $this->downloadUrl = $downloadUrl;
        $this->linkText = $linkText;
    }

    public function withLastModified(?DateTimeImmutable $lastModified): self
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

    public function isResolved(): bool
    {
        return ('' !== $this->downloadUrl);
    }

    public function linkText(): string
    {
        return $this->linkText;
    }
}
