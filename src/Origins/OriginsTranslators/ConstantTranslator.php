<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\TranslatorInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\ConstantOrigin;

final class ConstantTranslator implements TranslatorInterface
{
    use TranslatorHelpersTrait;

    public const string TYPE = 'const';

    public function allowType(string $type): bool
    {
        return self::TYPE === $type;
    }

    public function originFromArray(array $data): OriginInterface
    {
        return new ConstantOrigin(
            strval($data['name'] ?? ''),
            strval($data['href'] ?? ''),
            $this->dateTimeFromStringOrNull(strval($data['last-update'] ?? '')),
            strval($data['destination-file'] ?? ''),
        );
    }

    public function originToArray(OriginInterface $origin): array
    {
        if (! $origin instanceof ConstantOrigin) {
            throw new LogicException('Invalid origin to export to array');
        }

        return array_filter([
            'name' => $origin->name(),
            'href' => $origin->url(),
            'destination-file' => $origin->destinationFilename(),
            'last-update' => ($origin->hasLastVersion()) ? $origin->lastVersion()->format('c') : '',
        ]);
    }
}
