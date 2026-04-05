<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use LogicException;

interface TranslatorInterface
{
    public function allowType(string $type): bool;

    /** @param array<string, string> $data */
    public function originFromArray(array $data): OriginInterface;

    /**
     * @return array<string, string>
     * @throws LogicException if pass a not specific origin
     */
    public function originToArray(OriginInterface $origin): array;
}
