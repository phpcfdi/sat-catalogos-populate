<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;

class UrlResponse
{
    private string $url;

    private int $httpStatus;

    private DateTimeImmutable $lastModified;

    private string $body;

    public function __construct(string $url, int $httpStatus, DateTimeImmutable $lastModified = null, string $body = '')
    {
        $this->url = $url;
        $this->httpStatus = $httpStatus;
        $this->lastModified = ($lastModified) ?: new DateTimeImmutable();
        $this->body = $body;
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

    public function body(): string
    {
        return $this->body;
    }
}
