<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators\ConstantTranslator;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators\HidroPetro10Translator;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators\Nomina12eTranslator;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslators\ScrapingTranslator;
use RuntimeException;

final readonly class Translator implements TranslatorInterface
{
    /** @param array<string, TranslatorInterface> $translators */
    public function __construct(private array $translators)
    {
    }

    public static function create(): self
    {
        return new self([
            ConstantTranslator::TYPE => new ConstantTranslator(),
            ScrapingTranslator::TYPE => new ScrapingTranslator(),
            Nomina12eTranslator::TYPE => new Nomina12eTranslator(),
            HidroPetro10Translator::TYPE => new HidroPetro10Translator(),
        ]);
    }

    public function findTranslatorByType(string $type): TranslatorInterface|null
    {
        $type = ('' === $type) ? ConstantTranslator::TYPE : $type;

        return array_find(
            $this->translators,
            static fn (TranslatorInterface $translator): bool => $translator->allowType($type),
        );
    }

    public function getTranslatorByType(string $type): TranslatorInterface
    {
        $translator = $this->findTranslatorByType($type);
        if (null === $translator) {
            throw new RuntimeException("Translator not found for key $type");
        }
        return $translator;
    }

    public function allowType(string $type): bool
    {
        return null !== $this->findTranslatorByType($type);
    }

    /** @inheritdoc */
    public function originFromArray(array $data): OriginInterface
    {
        $type = strval($data['type'] ?? '');

        $translator = $this->getTranslatorByType($type);
        return $translator->originFromArray($data);
    }

    /** @return array<string, string> */
    public function originToArray(OriginInterface $origin): array
    {
        $translator = $this->getTranslatorByType($origin->type());
        return $translator->originToArray($origin);
    }
}
