<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\ImporterInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CceCatalogs implements ImporterInterface
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
            'c_ClavePedimento.xls' => new Cce\CceClavePedimento(),
            'c_Colonia.xls' => new Cce\CceColonia(),
            'C_Estado.xls' => new Cce\CceEstado(),
            'c_FraccionArancelaria_20170101.xls' => new Cce\CceFraccionArancelaria(true),
            'c_FraccionArancelaria_20201228.xls' => new Cce\CceFraccionArancelaria(false),
            'c_FraccionArancelaria_20221212.xls' => new Cce\CceFraccionArancelaria(false),
            'c_INCOTERM.xls' => new Cce\CceIncoterm(),
            'c_Localidad.xls' => new Cce\CceLocalidad(),
            'c_MotivoTraslado.xls' => new Cce\CceMotivoTraslado(),
            'c_Municipio.xls' => new Cce\CceMunicipio(),
            'c_TipoOperacion.xls' => new Cce\CceTipoOperacion(),
            'c_UnidadAduana.xls' => new Cce\CceUnidadAduana(),
        ];
    }
}
