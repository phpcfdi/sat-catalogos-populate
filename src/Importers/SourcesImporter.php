<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\ImporterInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

class SourcesImporter implements ImporterInterface
{
    public function import(string $source, Repository $repository, LoggerInterface $logger): void
    {
        $importers = [
            'CFDI' => ['source' => $source . '/catCFDI.xls', 'importer' => new CfdiCatalogs()],
            'CFDI 4.0' => ['source' => $source . '/cfdi_40.xls', 'importer' => new Cfdi40Catalogs()],
            'Nóminas' => ['source' => $source . '/catNomina.xls', 'importer' => new NominaCatalogs()],
            'Nóminas - Estados' => [
                'source' => $source . '/nominas_estados.xls',
                'importer' => new NominaEstadosCatalogs(),
            ],
            'CCE' => ['source' => $source, 'importer' => new CceCatalogs()],
            'Pagos' => ['source' => $source . '/catPagos.xls', 'importer' => new RepCatalogs()],
        ];

        foreach ($importers as $name => $info) {
            $sourceFile = $info['source'];
            if (! file_exists($sourceFile)) {
                throw new RuntimeException("Se esperaba encontrar $sourceFile pero no existe");
            }
        }

        foreach ($importers as $name => $info) {
            /** @var ImporterInterface $importer */
            $sourceFile = $info['source'];
            $importer = $info['importer'];
            $logger->info("Importando $name desde $sourceFile...");
            $importer->import($sourceFile, $repository, $logger);
        }
    }
}
