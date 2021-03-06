<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin;
use Psr\Log\LoggerInterface;

class DumpOrigins implements CommandInterface
{
    public function run(): int
    {
        $common = 'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos';
        $origins = new Origins([
            new ConstantOrigin('CFDI', "{$common}/catCFDI.xls"),
            new ConstantOrigin('Nóminas', "{$common}/catNomina.xls"),
            new ConstantOrigin('CCE - Claves de pedimento', "{$common}/c_ClavePedimento.xls"),
            new ConstantOrigin('CCE - Colonias', "{$common}/c_Colonia.xls"),
            new ConstantOrigin('CCE - Entidades o estados', "{$common}/C_Estado.xls"),
            new ConstantOrigin('CCE - Fracciones arancelarias 2020', "{$common}/c_FraccionArancelaria.xls"),
            new ScrapingOrigin(
                'CCE - Fracciones arancelarias 2021',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/catalogos_emision_cfdi_complemento_ce.htm',
                'c_FraccionArancelaria_2021.xls',
                'Catálogo vigente a partir del 28 de diciembre de 2020',
            ),
            new ConstantOrigin('CCE - Incoterms', "{$common}/c_INCOTERM.xls"),
            new ConstantOrigin('CCE - Localidades', "{$common}/c_Localidad.xls"),
            new ConstantOrigin('CCE - Motivo traslado', "{$common}/c_MotivoTraslado.xls"),
            new ConstantOrigin('CCE - Municipios', "{$common}/c_Municipio.xls"),
            new ConstantOrigin('CCE - Tipos de operaciones', "{$common}/c_TipoOperacion.xls"),
            new ConstantOrigin('CCE - Unidades de medida', "{$common}/c_UnidadAduana.xls"),
            new ConstantOrigin('REP', "{$common}/catPagos.xls"),
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
