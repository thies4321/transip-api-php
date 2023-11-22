<?php

declare(strict_types=1);

namespace TransIP\Api\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use TransIP\Api\Serializer\Converter\DomainConverter;

/**
 * @method array getSupportedTypes(?string $format)
 */
final class DomainDenormalizer implements DenormalizerInterface
{
    public const FORMAT = 'domain';

    public function denormalize(mixed $data, string $type, string $format = null, array $context = [])
    {
        return DomainConverter::forArray($data['domain']);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return self::FORMAT === $type;
    }
}
