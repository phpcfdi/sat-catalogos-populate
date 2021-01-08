<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use DOMDocument;
use SimpleXMLElement;

class OriginsIO
{
    public function readFile(string $filename): Origins
    {
        return $this->originsFromString(file_get_contents($filename) ?: '');
    }

    public function writeFile(string $filename, Origins $origins): void
    {
        file_put_contents($filename, $this->originsToString($origins));
    }

    public function originsFromString(string $xmlContent): Origins
    {
        $origins = [];
        $xml = new SimpleXMLElement($xmlContent);
        foreach ($xml->{'origin'} as $origin) {
            $origins[] = $this->readOrigin($origin);
        }

        return new Origins($origins);
    }

    protected function readOrigin(SimpleXMLElement $origin): OriginInterface
    {
        $nameValue = (string) $origin['name'];
        $hrefValue = (string)$origin['href'];
        $lastUpdateValue = (string) $origin['last-update'];
        /** @noinspection PhpUnhandledExceptionInspection */
        $lastUpdate = ('' !== $lastUpdateValue) ? new DateTimeImmutable($lastUpdateValue) : null;
        return new Origin($nameValue, $hrefValue, $lastUpdate);
    }

    public function originsToString(Origins $origins): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = true;
        $document->preserveWhiteSpace = false;
        $root = $document->createElement('origins');
        $document->appendChild($root);
        /** @var Origin $origin */
        foreach ($origins as $origin) {
            $child = $document->createElement('origin');
            $child->setAttribute('name', $origin->name());
            $child->setAttribute('href', $origin->url());
            if ($origin->hasLastVersion()) {
                $child->setAttribute('last-update', $origin->lastVersion()->format('c'));
            }
            $root->appendChild($child);
        }

        return $document->saveXML() ?: '';
    }
}
