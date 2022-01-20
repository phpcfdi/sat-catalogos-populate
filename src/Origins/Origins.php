<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\AbstractCollection;

/**
 * @extends AbstractCollection<OriginInterface>
 */
class Origins extends AbstractCollection
{
    public function isValidMember(mixed $member): bool
    {
        return ($member instanceof OriginInterface);
    }
}
