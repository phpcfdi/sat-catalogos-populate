<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class TextDataField extends AbstractDataField implements DataFieldInterface
{
    public function transform($input)
    {
        return parent::transform(trim((string) $input));
    }
}
