<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators;

use DateTimeImmutable;

trait TranslatorHelpersTrait
{
    public function dateTimeFromStringOrNull(string $value): DateTimeImmutable|null
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return ('' !== $value) ? new DateTimeImmutable($value) : null;
    }
}
