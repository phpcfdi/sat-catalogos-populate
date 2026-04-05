<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\HidroPetro10Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\Nomina12eOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\ScrapingOrigin;
use RuntimeException;

final class OriginsTranslator implements OriginsTranslatorInterface
{
    /** @inheritdoc */
    public function originFromArray(array $data): OriginInterface
    {
        $type = strval($data['type'] ?? '') ?: 'const';
        if ('const' === $type) {
            return $this->constantOriginFromArray($data);
        }
        if ('scrap' === $type) {
            return $this->scrapingOriginFromArray($data);
        }
        if ('nomina12e' === $type) {
            return $this->nomina12eOriginFromArray($data);
        }
        if ('hidropetro10' === $type) {
            return $this->hidroPetro10OriginFromArray($data);
        }
        throw new RuntimeException("Unable to create an origin with type $type");
    }

    /** @param array<string, string> $data */
    public function constantOriginFromArray(array $data): ConstantOrigin
    {
        return new ConstantOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
            strval($data['destination-file'] ?? ''),
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
        if ($origin instanceof Nomina12eOrigin) {
            return $this->constantNomina12eToArray($origin);
        }
        if ($origin instanceof HidroPetro10Origin) {
            return $this->constantHidroPetro10ToArray($origin);
        }
        throw new RuntimeException(sprintf('Unable to export an origin with type %s', $origin::class));
    }

    /** @param array<string, string> $data */
    public function scrapingOriginFromArray(array $data): ScrapingOrigin
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

    /** @param array<string, string> $data */
    public function nomina12eOriginFromArray(array $data): Nomina12eOrigin
    {
        return new Nomina12eOrigin(
            strval($data['destination-file'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
        );
    }

    /** @param array<string, string> $data */
    public function hidroPetro10OriginFromArray(array $data): HidroPetro10Origin
    {
        return new HidroPetro10Origin(
            strval($data['destination-file'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
        );
    }

    public function dateTimeFromStringOrNull(string $value): DateTimeImmutable|null
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
            'link-position' => strval($origin->linkPosition()),
        ]);
    }

    /** @return array<string, string> */
    public function constantNomina12eToArray(Nomina12eOrigin $origin): array
    {
        return array_filter([
            'type' => 'nomina12e',
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }

    /** @return array<string, string> */
    public function constantHidroPetro10ToArray(HidroPetro10Origin $origin): array
    {
        return array_filter([
            'type' => 'hidropetro10',
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }
}
