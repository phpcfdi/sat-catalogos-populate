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
            'CFDI 3.3' => ['source' => $source . '/catCFDI.xls', 'importer' => new CfdiCatalogs()],
            'CFDI 4.0' => ['source' => $source . '/cfdi_40.xls', 'importer' => new Cfdi40Catalogs()],
            'Nóminas' => ['source' => $source . '/catNomina.xls', 'importer' => new NominaCatalogs()],
            'Nóminas - Estados' => [
                'source' => $source . '/nominas_estados.xls',
                'importer' => new NominaEstadosCatalogs(),
            ],
            'CCE 1.1' => ['source' => $source, 'importer' => new CceCatalogs()],
            'CCE 2.0' => ['source' => $source, 'importer' => new Cce20Catalogs()],
            'Pagos' => ['source' => $source . '/catPagos.xls', 'importer' => new RepCatalogs()],
            'CCP 2.0' => ['source' => $source . '/CatalogosCartaPorte20.xls', 'importer' => new Ccp20Catalogs()],
            'CCP 3.0' => ['source' => $source . '/CatalogosCartaPorte30.xls', 'importer' => new Ccp30Catalogs()],
            'RET 2.0' => ['source' => $source . '/ret_20.xls', 'importer' => new Ret20Catalogs()],
        ];

        foreach ($importers as $info) {
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
