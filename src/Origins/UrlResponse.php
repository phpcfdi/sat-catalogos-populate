<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;

class UrlResponse
{
    /** @var string */
    private $url;

    /** @var int */
    private $httpStatus;

    /** @var DateTimeImmutable */
    private $lastModified;

    public function __construct(string $url, int $httpStatus, DateTimeImmutable $lastModified = null)
    {
        $this->url = $url;
        $this->httpStatus = $httpStatus;
        $this->lastModified = ($lastModified) ?: new DateTimeImmutable();
    }

    public function url(): string
    {
        return $this->url;
    }

    public function httpStatus(): int
    {
        return $this->httpStatus;
    }

    public function lastModified(): DateTimeImmutable
    {
        return $this->lastModified;
    }

    public function isSuccess(): bool
    {
        return 200 === $this->httpStatus;
    }

    public function dateMatch(DateTimeImmutable $date): bool
    {
        return ($this->lastModified->format('U') === $date->format('U'));
    }
}
