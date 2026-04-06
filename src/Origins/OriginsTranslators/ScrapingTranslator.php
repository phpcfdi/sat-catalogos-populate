<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\TranslatorInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\ScrapingOrigin;

final class ScrapingTranslator implements TranslatorInterface
{
    use TranslatorHelpersTrait;

    public const string TYPE = 'scrap';

    public function allowType(string $type): bool
    {
        return self::TYPE === $type;
    }

    public function originFromArray(array $data): OriginInterface
    {
        return new ScrapingOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            strval($data['destination-file'] ?? ''),
            strval($data['link-text'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
            linkPosition: intval($data['link-position'] ?? 0),
        );
    }

    public function originToArray(OriginInterface $origin): array
    {
        if (! $origin instanceof ScrapingOrigin) {
            throw new LogicException('Invalid origin to export to array');
        }

        return array_filter([
            'name' => $origin->name(),
            'type' => self::TYPE,
            'href' => $origin->url(),
            'link-text' => $origin->linkText(),
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
            'link-position' => strval($origin->linkPosition()),
        ]);
    }
}
