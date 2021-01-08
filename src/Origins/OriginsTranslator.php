<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use RuntimeException;

final class OriginsTranslator
{
    public function originFromArray(array $data): OriginInterface
    {
        $type = ($data['type'] ?? '') ?: 'const';
        if ('const' === $type) {
            return $this->constantOriginFromArray($data);
        }
        throw new RuntimeException("Unable to create an origin with type $type");
    }

    public function constantOriginFromArray(array $data): ConstantOrigin
    {
        return new ConstantOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
            strval($data['destination-file'] ?? '')
        );
    }

    public function originToArray(OriginInterface $origin): array
    {
        if ($origin instanceof ConstantOrigin) {
            return $this->constantOriginToArray($origin);
        }
        throw new RuntimeException(sprintf('Unable to export an origin with type %s', get_class($origin)));
    }

    public function dateTimeFromStringOrNull(string $value): ?DateTimeImmutable
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return ('' !== $value) ? new DateTimeImmutable($value) : null;
    }

    public function constantOriginToArray(ConstantOrigin $origin): array
    {
        return array_filter([
            'name' => $origin->name(),
            'href' => $origin->url(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
            'destination-file' => $origin->destinationFilename(),
        ]);
    }
}
