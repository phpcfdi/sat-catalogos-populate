<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\TranslatorInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\HidroPetro10Origin;

final class HidroPetro10Translator implements TranslatorInterface
{
    use TranslatorHelpersTrait;

    public const string TYPE = 'hidropetro10';

    public function allowType(string $type): bool
    {
        return self::TYPE === $type;
    }

    public function originFromArray(array $data): OriginInterface
    {
        return new HidroPetro10Origin(
            strval($data['destination-file'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
        );
    }

    public function originToArray(OriginInterface $origin): array
    {
        if (! $origin instanceof HidroPetro10Origin) {
            throw new LogicException('Invalid origin to export to array');
        }
        return array_filter([
            'type' => self::TYPE,
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }
}
