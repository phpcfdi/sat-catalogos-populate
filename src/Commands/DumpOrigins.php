<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Origins\Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use Psr\Log\LoggerInterface;

class DumpOrigins implements CommandInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function run(): int
    {
        $common = 'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos';
        $origins = new Origins([
            new Origin('CFDI', "{$common}/catCFDI.xls"),
            new Origin('Nóminas', 'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/catNomina.xls'),
            new Origin('CCE - Claves de pedimento', "{$common}/c_ClavePedimento.xls"),
            new Origin(
                'CCE - Colonias',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_Colonia.xls'
            ),
            new Origin(
                'CCE - Entidades o estados',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/C_Estado.xls'
            ),
            new Origin(
                'CCE - Fracciones arancelarias',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_FraccionArancelaria.xls'
            ),
            new Origin(
                'CCE - Incoterms',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_INCOTERM.xls'
            ),
            new Origin(
                'CCE - Localidades',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_Localidad.xls'
            ),
            new Origin(
                'CCE - Motivo traslado',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_MotivoTraslado.xls'
            ),
            new Origin(
                'CCE - Municipios',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_Municipio.xls'
            ),
            new Origin(
                'CCE - Tipos de operaciones',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_TipoOperacion.xls'
            ),
            new Origin(
                'CCE - Unidades de medida',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/c_UnidadAduana.xls'
            ),
            new Origin(
                'REP',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/catPagos.xls'
            ),
        ]);
        echo (new OriginsIO())->originsToString($origins) . PHP_EOL;

        return 0;
    }

    public static function createFromArguments(array $arguments): CommandInterface
    {
        return new self();
    }

    public static function help(string $commandName): string
    {
        return "Sintax: $commandName";
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
