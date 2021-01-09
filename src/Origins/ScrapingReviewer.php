<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use LogicException;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingReviewer implements ReviewerInterface
{
    /** @var ResourcesGatewayInterface */
    private $gateway;

    public function __construct(ResourcesGatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function gateway(): ResourcesGatewayInterface
    {
        return $this->gateway;
    }

    public function accepts(OriginInterface $origin): bool
    {
        return ($origin instanceof ScrapingOrigin);
    }

    public function review(OriginInterface $origin): Review
    {
        if (! $origin instanceof ScrapingOrigin) {
            throw new LogicException('This reviewer can only handle ScrapingOrigin objects');
        }

        if (! $origin->hasDownloadUrl()) {
            try {
                $origin = $this->resolveOrigin($origin);
            } catch (RuntimeException $exception) {
                return new Review($origin, ReviewStatus::notFound());
            }
        }

        $response = $this->gateway->headers($origin->downloadUrl());

        // si no se pudo obtener el recurso
        if (! $response->isSuccess()) {
            return new Review($origin, ReviewStatus::notFound());
        }

        // si el recurso no coincide con la última versión
        if (! $origin->hasLastVersion() || ! $response->dateMatch($origin->lastVersion())) {
            return new Review($origin, ReviewStatus::notUpdated());
        }

        // entonces el recurso coincide
        return new Review($origin, ReviewStatus::uptodate());
    }

    public function resolveOrigin(ScrapingOrigin $origin): ScrapingOrigin
    {
        $baseResource = $this->gateway->get($origin->url(), '');
        $downloadUrl = $this->resolveHtmlToLink($baseResource, $origin->linkText());
        return $origin->withDownloadUrl($downloadUrl);
    }

    public function resolveHtmlToLink(UrlResponse $response, string $linkText): string
    {
        if (empty($response->body())) {
            throw new RuntimeException('Content is empty');
        }
        $crawler = new Crawler($response->body(), $response->url());
        $link = $crawler->selectLink($linkText)->link();
        $downloadUrl = $link->getUri();
        if (empty($downloadUrl)) {
            throw new RuntimeException('The link was found but it does not contains the url to download');
        }

        return $downloadUrl;
    }
}
