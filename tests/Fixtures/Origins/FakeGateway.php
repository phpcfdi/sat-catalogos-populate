<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\UrlResponse;

class FakeGateway implements ResourcesGatewayInterface
{
    /** @var array<string, array> */
    public $collection = [];

    ///** @var bool */
    //public $realCopy = false;

    public function add(UrlResponse $urlResponse, string $filename = ''): void
    {
        $this->collection[$urlResponse->url()] = [
            'urlResponse' => $urlResponse,
            'filename' => $filename,
        ];
    }

    public function headers(string $url): UrlResponse
    {
        if (! isset($this->collection[$url])) {
            return new UrlResponse($url, 404);
        }
        return $this->collection[$url]['urlResponse'];
    }

    public function get(string $url, string $destination): UrlResponse
    {
        if (! isset($this->collection[$url])) {
            return new UrlResponse($url, 404);
        }
        //if ($this->realCopy) {
        //    copy($this->collection[$url]['filename'], $destination);
        //}
        return $this->collection[$url]['urlResponse'];
    }
}
