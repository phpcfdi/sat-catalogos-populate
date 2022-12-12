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
            new ScrapingOrigin(
                'CFDI 3.3',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20_version3-3.htm',
                'catCFDI.xls',
                'Catálogos CFDI Versión 3.3*',
            ),
            new ScrapingOrigin(
                'CFDI 4.0',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20_version3-3.htm',
                'cfdi_40.xls',
                'Catálogos CFDI Versión 4.0*',
            ),
            new ConstantOrigin('Nóminas', "{$common}/catNomina.xls"),
            new ConstantOrigin('Nóminas - Estados', "{$common}/C_Estado.xls", null, 'nominas_estados.xls'),
            new ConstantOrigin('CCE - Claves de pedimento', "{$common}/c_ClavePedimento.xls"),
            new ConstantOrigin('CCE - Colonias', "{$common}/c_Colonia.xls"),
            new ConstantOrigin('CCE - Entidades o estados', "{$common}/C_Estado.xls"),
            new ConstantOrigin(
                'CCE - Fracciones arancelarias 2020',
                "{$common}/c_FraccionArancelaria.xls",
                destinationFilename: 'c_FraccionArancelaria_20170101.xls'
            ),
            new ScrapingOrigin(
                'CCE - Fracciones arancelarias 20201228',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/catalogos_emision_cfdi_complemento_ce.htm?20201228',
                'c_FraccionArancelaria_20201228.xls',
                '*Catálogo vigente del 28 de diciembre de 2020 al 11 de diciembre de 2022*'
            ),
            new ScrapingOrigin(
                'CCE - Fracciones arancelarias 20221212',
                'http://omawww.sat.gob.mx/tramitesyservicios/Paginas/catalogos_emision_cfdi_complemento_ce.htm?20221212',
                'c_FraccionArancelaria_20221212.xls',
                '*Catálogo vigente a partir del 12 de diciembre de 2022*',
            ),
            new ConstantOrigin('CCE - Incoterms', "{$common}/c_INCOTERM.xls"),
            new ConstantOrigin('CCE - Localidades', "{$common}/c_Localidad.xls"),
            new ConstantOrigin('CCE - Motivo traslado', "{$common}/c_MotivoTraslado.xls"),
            new ConstantOrigin('CCE - Municipios', "{$common}/c_Municipio.xls"),
            new ConstantOrigin('CCE - Tipos de operaciones', "{$common}/c_TipoOperacion.xls"),
            new ConstantOrigin('CCE - Unidades de medida', "{$common}/c_UnidadAduana.xls"),
            new ConstantOrigin('REP', "{$common}/catPagos.xls"),
            new ConstantOrigin('CCP 2.0 - Carta Porte', "{$common}/CatalogosCartaPorte20.xls"),
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
