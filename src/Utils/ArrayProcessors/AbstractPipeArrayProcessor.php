<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors;

abstract class AbstractPipeArrayProcessor implements ArrayProcessorInterface
{
    /** @var ArrayProcessorInterface */
    private $next;

    public function __construct(ArrayProcessorInterface $next = null)
    {
        $this->next = (null === $next) ? new NullArrayProcessor() : $next;
    }

    public function execute(array $array): array
    {
        return $this->next->execute($array);
    }
}
