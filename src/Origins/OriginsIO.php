<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DOMDocument;
use SimpleXMLElement;

class OriginsIO
{
    private OriginsTranslator $translator;

    public function __construct()
    {
        $this->translator = new OriginsTranslator();
    }

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
        /** @noinspection PhpUnhandledExceptionInspection */
        $xml = new SimpleXMLElement($xmlContent);
        foreach ($xml->{'origin'} as $origin) {
            $origins[] = $this->readOrigin($origin);
        }

        return new Origins($origins);
    }

    protected function readOrigin(SimpleXMLElement $origin): OriginInterface
    {
        $attributes = [];
        foreach (($origin->attributes() ?? []) as $key => $value) {
            $attributes[$key] = (string) $value;
        }

        return $this->translator->originFromArray($attributes);
    }

    public function originsToString(Origins $origins): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->formatOutput = true;
        $document->preserveWhiteSpace = false;
        $root = $document->createElement('origins');
        $document->appendChild($root);
        /** @var OriginInterface $origin */
        foreach ($origins as $origin) {
            $child = $document->createElement('origin');
            foreach ($this->translator->originToArray($origin) as $key => $value) {
                $child->setAttribute($key, $value);
            }
            $root->appendChild($child);
        }

        return $document->saveXML() ?: '';
    }
}
