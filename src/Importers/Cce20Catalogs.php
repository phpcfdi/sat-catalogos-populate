<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\ImporterInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

class Cce20Catalogs implements ImporterInterface
{
    /**
     * @param string $source Folder where all files exist
     */
    public function import(string $source, Repository $repository, LoggerInterface $logger): void
    {
        $importers = $this->createImporters();
        foreach ($importers as $file => $importer) {
            $sourceFile = $source . '/' . $file;
            if (! file_exists($sourceFile) || is_dir($sourceFile) || ! is_readable($sourceFile)) {
                throw new RuntimeException("No se encontró el archivo $sourceFile");
            }
            $importer->import($sourceFile, $repository, $logger);
        }
    }

    /** @return array<string, ImporterInterface> */
    public function createImporters(): array
    {
        return [
            'c_ClavePedimento20.xls' => new Cce20\CceClavePedimento(),
            'c_Colonia20.xls' => new Cce20\CceColonia(),
            'C_Estado20.xls' => new Cce20\CceEstado(),
            'c_FraccionArancelaria_cce20_20221212.xls' => new Cce20\CceFraccionArancelaria(),
            'c_INCOTERM20.xls' => new Cce20\CceIncoterm(),
            'c_Localidad20.xls' => new Cce20\CceLocalidad(),
            'c_MotivoTraslado20.xls' => new Cce20\CceMotivoTraslado(),
            'c_Municipio20.xls' => new Cce20\CceMunicipio(),
            'c_TipoOperacion20.xls' => new Cce20\CceTipoOperacion(),
            'c_UnidadAduana20.xls' => new Cce20\CceUnidadAduana(),
        ];
    }
}
