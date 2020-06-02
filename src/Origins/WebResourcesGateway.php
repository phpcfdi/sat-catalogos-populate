<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class WebResourcesGateway implements ResourcesGatewayInterface
{
    /** @var GuzzleClient */
    private $client;

    public function __construct(GuzzleClient $client = null)
    {
        $this->client = ($client) ?: new GuzzleClient();
    }

    private function obtainResponse(string $method, string $url): ResponseInterface
    {
        try {
            $response = $this->client->request($method, $url, [
                RequestOptions::DEBUG => false, // set to true to debug download problems
            ]);
        } catch (RequestException $exception) {
            if (! $exception->hasResponse()) {
                throw $exception;
            }
            /** @var ResponseInterface $response */
            $response = $exception->getResponse();
        }
        return $response;
    }

    private function createUrlResponseFromResponse(ResponseInterface $response, string $url): UrlResponse
    {
        $lastModified = null;
        if ($response->hasHeader('Last-Modified')) {
            $lastModified = new DateTimeImmutable($response->getHeaderLine('Last-Modified'));
        }

        return new UrlResponse($url, $response->getStatusCode(), $lastModified);
    }

    public function headers(string $url): UrlResponse
    {
        $response = $this->obtainResponse('HEAD', $url);
        return $this->createUrlResponseFromResponse($response, $url);
    }

    public function get(string $url, string $destination): UrlResponse
    {
        $response = $this->obtainResponse('GET', $url);
        if (200 === $response->getStatusCode()) {
            file_put_contents($destination, $response->getBody());
        }

        return $this->createUrlResponseFromResponse($response, $url);
    }
}
