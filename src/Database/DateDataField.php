<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

use DateTime;
use RuntimeException;

class DateDataField extends AbstractDataField implements DataFieldInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name, function ($input) use ($name): string {
            // empty string
            if ('' === $input) {
                return '';
            }

            // input formats
            foreach (['Y-m-d', 'd/m/Y'] as $format) {
                $date = DateTime::createFromFormat($format, $input);
                if ($date instanceof DateTime) {
                    return $date->format('Y-m-d');
                }
            }

            // don't know how to handle
            throw new RuntimeException("Para el campo $name la fecha $input no pudo ser interpretada");
        });
    }
}
