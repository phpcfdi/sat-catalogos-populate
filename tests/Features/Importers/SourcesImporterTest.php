<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Importers;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\SourcesImporter;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;

class SourcesImporterTest extends TestCase
{
    public function testImportSourcesFromFolder(): void
    {
        $sourceFolder = $this->utilFilePath('sources/');
        $repository = new Repository(':memory:');

        $importer = new SourcesImporter();

        $importer->import($sourceFolder, $repository, new NullLogger());

        $expectedTables = [
            'cfdi_paises',
            'cfdi_tipos_factores',
            'cfdi_productos_servicios',
            'cfdi_codigos_postales',
            'cfdi_claves_unidades',
            'cfdi_patentes_aduanales',
            'cfdi_regimenes_fiscales',
            'cfdi_aduanas',
            'cfdi_monedas',
            'cfdi_metodos_pago',
            'cfdi_tipos_comprobantes',
            'cfdi_tipos_relaciones',
            'cfdi_impuestos',
            'cfdi_formas_pago',
            'cfdi_usos_cfdi',
            'cce_claves_pedimentos',
            'cce_tipos_operacion',
            'cce_estados',
            'cce_unidades_medida',
            'cce_motivos_traslado',
            'cce_colonias',
            'cce_municipios',
            'cce_incoterms',
            'cce_fracciones_arancelarias',
            'cce_localidades',
            'nomina_tipos_contratos',
            'nomina_bancos',
            'nomina_riesgos_puestos',
            'nomina_periodicidades_pagos',
            'nomina_tipos_horas',
            'nomina_tipos_jornadas',
            'nomina_estados',
            'nomina_tipos_nominas',
            'nomina_origenes_recursos',
            'nomina_tipos_otros_pagos',
            'nomina_tipos_incapacidades',
            'nomina_tipos_deducciones',
            'nomina_tipos_percepciones',
            'nomina_tipos_regimenes',
            'pagos_tipos_cadena_pago',
        ];

        foreach ($expectedTables as $expectedTable) {
            $this->assertTrue(
                $repository->hasTable($expectedTable),
                "The table $expectedTable was not found in repository"
            );
            $this->assertGreaterThan(0, $repository->getRecordCount($expectedTable));
        }
    }
}
