<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use RuntimeException;

final class OriginsTranslator
{
    /** @param array<string, mixed> $data */
    public function originFromArray(array $data): OriginInterface
    {
        $type = strval($data['type'] ?? '') ?: 'const';
        if ('const' === $type) {
            return $this->constantOriginFromArray($data);
        }
        if ('scrap' === $type) {
            return $this->scrapingOriginFromArray($data);
        }
        throw new RuntimeException("Unable to create an origin with type $type");
    }

    /** @param array<string, mixed> $data */
    public function constantOriginFromArray(array $data): ConstantOrigin
    {
        return new ConstantOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
            strval($data['destination-file'] ?? '')
        );
    }

    /** @return array<string, string> */
    public function originToArray(OriginInterface $origin): array
    {
        if ($origin instanceof ConstantOrigin) {
            return $this->constantOriginToArray($origin);
        }
        if ($origin instanceof ScrapingOrigin) {
            return $this->scrapingOriginToArray($origin);
        }
        throw new RuntimeException(sprintf('Unable to export an origin with type %s', get_class($origin)));
    }

    /** @param array<string, mixed> $data */
    public function scrapingOriginFromArray(array $data): ScrapingOrigin
    {
        return new ScrapingOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            strval($data['destination-file'] ?? ''),
            strval($data['link-text'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? ''))
        );
    }

    public function dateTimeFromStringOrNull(string $value): ?DateTimeImmutable
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return ('' !== $value) ? new DateTimeImmutable($value) : null;
    }

    /** @return array<string, string> */
    public function constantOriginToArray(ConstantOrigin $origin): array
    {
        return array_filter([
            'name' => $origin->name(),
            'href' => $origin->url(),
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }

    /** @return array<string, string> */
    public function scrapingOriginToArray(ScrapingOrigin $origin): array
    {
        return array_filter([
            'name' => $origin->name(),
            'type' => 'scrap',
            'href' => $origin->url(),
            'link-text' => $origin->linkText(),
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }
}
