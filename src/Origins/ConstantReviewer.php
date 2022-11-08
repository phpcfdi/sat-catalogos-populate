<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use LogicException;

class ConstantReviewer implements ReviewerInterface
{
    public function __construct(private readonly ResourcesGatewayInterface $gateway)
    {
    }

    public function accepts(OriginInterface $origin): bool
    {
        return ($origin instanceof ConstantOrigin);
    }

    public function review(OriginInterface $origin): Review
    {
        if (! $origin instanceof ConstantOrigin) {
            throw new LogicException('This reviewer can only handle ConstantOrigin objects');
        }

        // obtener la información de la url del origen
        $response = $this->gateway->headers($origin->url());

        // si no se pudo obtener el recurso
        if (! $response->isSuccess()) {
            return new Review($origin, ReviewStatus::notFound());
        }

        // si el recurso no coincide con la última versión
        if (! $origin->hasLastVersion() || ! $response->dateMatch($origin->lastVersion())) {
            return new Review($origin, ReviewStatus::notUpdated());
        }

        // entonces el recurso coincide
        return new Review($origin, ReviewStatus::uptodate());
    }
}
