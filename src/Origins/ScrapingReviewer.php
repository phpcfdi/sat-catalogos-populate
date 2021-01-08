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

    public function accept(OriginInterface $origin): bool
    {
        return ($origin instanceof ScrapingOrigin);
    }

    public function review(OriginInterface $origin): Review
    {
        if (! $origin instanceof ScrapingOrigin) {
            throw new LogicException('This revewer can only handle ScrapingOrigin objects');
        }

        if (! $origin->isResolved()) {
            $origin = $this->resolveOrigin($origin);
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
        $gateway = $this->gateway();
        $baseResource = $gateway->get($origin->url(), '');
        $downloadUrl = $this->resolveHtmlToLink($baseResource->body(), $origin->linkText());
        return $origin->withDownloadUrl($downloadUrl);
    }

    public function resolveHtmlToLink(string $html, string $linkText): string
    {
        if (empty($html)) {
            throw new RuntimeException('Content is empty');
        }
        $crawler = new Crawler($html);
        $link = $crawler->selectLink($linkText);
        $downloadUrl = strval($link->attr('href'));
        if (empty($downloadUrl)) {
            throw new RuntimeException('The link was foung but it does not contains the url to download');
        }

        return $downloadUrl;
    }
}
