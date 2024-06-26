<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

interface ResourcesGatewayInterface
{
    /**
     * This method retrieves the http-status and last-modification headers and
     * return the UrlResponde containing those data
     */
    public function headers(string $url): UrlResponse;

    /**
     * Obtain the web resource using Http GET method and optionally store it into destination
     * Return the UrlResponse with http-status and last-modification
     */
    public function get(string $url, string $destination): UrlResponse;
}
