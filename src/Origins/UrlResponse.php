<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface;
use Stringable;

class UrlResponse
{
    private DateTimeImmutable $lastModified;

    private Stringable|string $body;

    public function __construct(
        private string $url,
        private int $httpStatus,
        DateTimeImmutable $lastModified = null,
        Stringable|string $body = ''
    ) {
        $this->lastModified = ($lastModified) ?: new DateTimeImmutable();
        $this->body = $body;
    }

    public static function createFromResponse(ResponseInterface $response, string $url): self
    {
        $lastModified = null;
        if ($response->hasHeader('Last-Modified')) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $lastModified = new DateTimeImmutable($response->getHeaderLine('Last-Modified'));
        }

        return new self($url, $response->getStatusCode(), $lastModified, $response->getBody());
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
        return (string) $this->body;
    }
}
