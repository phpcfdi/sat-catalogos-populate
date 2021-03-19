<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Database;

class TextDataField extends AbstractDataField implements DataFieldInterface
{
    const MB_CHAR_NBSP = "\xC2\xA0";

    public function transform($input)
    {
        return parent::transform(trim(str_replace(self::MB_CHAR_NBSP, ' ', strval($input))));
    }
}
