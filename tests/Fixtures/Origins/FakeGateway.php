<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\UrlResponse;

class FakeGateway implements ResourcesGatewayInterface
{
    /** @var array<string, UrlResponse> */
    private array $collection = [];

    public function add(UrlResponse $urlResponse): void
    {
        $url = $this->normalizeUrl($urlResponse->url());
        $this->collection[$url] = $urlResponse;
    }

    public function headers(string $url): UrlResponse
    {
        $url = $this->normalizeUrl($url);
        if (! isset($this->collection[$url])) {
            return new UrlResponse($url, 404);
        }
        return $this->collection[$url];
    }

    public function get(string $url, string $destination): UrlResponse
    {
        $url = $this->normalizeUrl($url);
        if (! isset($this->collection[$url])) {
            return new UrlResponse($url, 404);
        }
        return $this->collection[$url];
    }

    private function normalizeUrl(string $url): string
    {
        return $url;
    }
}
