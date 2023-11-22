<?php

declare(strict_types=1);

namespace TransIP\Api\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use TransIP\Api\Serializer\Converter\DomainConverter;

use function array_map;

/**
 * @method array getSupportedTypes(?string $format)
 */
class DomainsDenormalizer implements DenormalizerInterface
{
    public const FORMAT = 'domains';

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return array_map(function (array $domain) {
            return DomainConverter::forArray($domain);
        }, $data['domains']);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return self::FORMAT === $type;
    }
}
