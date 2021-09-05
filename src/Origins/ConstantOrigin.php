<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use InvalidArgumentException;
use LogicException;

class ConstantOrigin implements OriginInterface
{
    private string $destinationFilename;

    public function __construct(
        private string $name,
        private string $url,
        private ?DateTimeImmutable $lastVersion = null,
        string $destinationFilename = ''
    ) {
        if ('' === $destinationFilename) {
            $destinationFilename = basename($destinationFilename);
        }
        if ('' === $destinationFilename) {
            $destinationFilename = ltrim(parse_url($url, PHP_URL_PATH) ?: '', '/');
        }
        if ('' === $destinationFilename) {
            throw new InvalidArgumentException('The is no destination filename and url does not have a valid basename');
        }
        $this->destinationFilename = $destinationFilename;
    }

    public function withLastModified(?DateTimeImmutable $lastModified): static
    {
        $clone = clone $this;
        $clone->lastVersion = $lastModified;
        return $clone;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
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
        return $this->url;
    }
}
