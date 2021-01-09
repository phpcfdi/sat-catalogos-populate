<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\AbstractCollection;

/**
 * @method OriginInterface[] all(): array
 */
class Origins extends AbstractCollection
{
    public function isValidMember($member): bool
    {
        return ($member instanceof OriginInterface);
    }
}
