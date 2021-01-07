<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Origins\Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use Psr\Log\LoggerInterface;

class DumpOrigins implements CommandInterface
{
    public function run(): int
    {
        $common = 'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos';
        $origins = new Origins([
            new Origin('CFDI', "{$common}/catCFDI.xls"),
            new Origin('Nóminas', "{$common}/catNomina.xls"),
            new Origin('CCE - Claves de pedimento', "{$common}/c_ClavePedimento.xls"),
            new Origin('CCE - Colonias', "{$common}/c_Colonia.xls"),
            new Origin('CCE - Entidades o estados', "{$common}/C_Estado.xls"),
            new Origin('CCE - Fracciones arancelarias', "{$common}/c_FraccionArancelaria.xls"),
            new Origin('CCE - Incoterms', "{$common}/c_INCOTERM.xls"),
            new Origin('CCE - Localidades', "{$common}/c_Localidad.xls"),
            new Origin('CCE - Motivo traslado', "{$common}/c_MotivoTraslado.xls"),
            new Origin('CCE - Municipios', "{$common}/c_Municipio.xls"),
            new Origin('CCE - Tipos de operaciones', "{$common}/c_TipoOperacion.xls"),
            new Origin('CCE - Unidades de medida', "{$common}/c_UnidadAduana.xls"),
            new Origin('REP', "{$common}/catPagos.xls"),
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
        //
    }
}
