<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin;
use Psr\Log\LoggerInterface;

final class DumpOrigins implements CommandInterface
{
    public function run(): int
    {
        $common = 'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos';
        $origins = new Origins([
            new ScrapingOrigin(
                'CFDI 3.3',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20.htm',
                'catCFDI.xls',
                'Catálogos CFDI Versión 3.3*',
            ),
            new ScrapingOrigin(
                'CFDI 4.0',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20.htm',
                'cfdi_40.xls',
                'Catálogos CFDI Versión 4.0*',
            ),
            new ScrapingOrigin(
                'RET 2.0',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/CFDI_retenciones.htm',
                'ret_20.xls',
                'Catálogos',
            ),
            new ConstantOrigin('Nóminas', "{$common}/catNomina.xls"),
            new ConstantOrigin('Nóminas - Estados', "{$common}/C_Estado.xls", null, 'nominas_estados.xls'),
            new ConstantOrigin('CCE 1.1 - Claves de pedimento', "{$common}/c_ClavePedimento.xls"),
            new ConstantOrigin('CCE 1.1 - Colonias', "{$common}/c_Colonia.xls"),
            new ConstantOrigin('CCE 1.1 - Entidades o estados', "{$common}/C_Estado.xls"),
            new ConstantOrigin(
                'CCE 1.1 - Fracciones arancelarias 2020',
                "{$common}/c_FraccionArancelaria.xls",
                destinationFilename: 'c_FraccionArancelaria_20170101.xls'
            ),
            new ScrapingOrigin(
                'CCE 1.1 - Fracciones arancelarias 20201228',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/catalogos_emision_cfdi_complemento_ce.htm',
                'c_FraccionArancelaria_20201228.xls',
                '*Catálogo vigente del 28 de diciembre de 2020 al 11 de diciembre de 2022*'
            ),
            new ScrapingOrigin(
                'CCE 1.1 - Fracciones arancelarias 20221212',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/catalogos_emision_cfdi_complemento_ce.htm',
                'c_FraccionArancelaria_20221212.xls',
                linkText: '*Catálogo vigente a partir del 12 de diciembre de 2022*',
                linkPosition: 1,
            ),
            new ConstantOrigin('CCE 1.1 - Incoterms', "{$common}/c_INCOTERM.xls"),
            new ConstantOrigin('CCE 1.1 - Localidades', "{$common}/c_Localidad.xls"),
            new ConstantOrigin('CCE 1.1 - Motivo traslado', "{$common}/c_MotivoTraslado.xls"),
            new ConstantOrigin('CCE 1.1 - Municipios', "{$common}/c_Municipio.xls"),
            new ConstantOrigin('CCE 1.1 - Tipos de operaciones', "{$common}/c_TipoOperacion.xls"),
            new ConstantOrigin('CCE 1.1 - Unidades de medida', "{$common}/c_UnidadAduana.xls"),
            new ConstantOrigin('REP', "{$common}/catPagos.xls"),
            new ConstantOrigin('CCP 2.0 - Carta Porte 2.0', "{$common}/CatalogosCartaPorte20.xls"),
            new ConstantOrigin('CCP 3.0 - Carta Porte 3.0', "{$common}/CatalogosCartaPorte30.xls"),
        ]);

        echo (new OriginsIO())->originsToString($origins) . PHP_EOL;

        return 0;
    }

    public static function createFromArguments(array $arguments): self
    {
        return new self();
    }

    public static function help(string $commandName): string
    {
        return "Syntax: $commandName";
    }

    public function setLogger(LoggerInterface $logger): void
    {
        //
    }
}
