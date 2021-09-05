<?php

declare(strict_types=1);

use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::PHP_74);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
//    $services->set(Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
//    $services->set(AddMethodCallBasedStrictParamTypeRector::class)->call('configure', [[
//        AddMethodCallBasedStrictParamTypeRector::TRUST_DOC_BLOCKS => true,
//    ]]);
};
