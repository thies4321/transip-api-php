<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;
use TransIP\Api\Entity\Domain;
use TransIP\Api\Serializer\DomainDenormalizer;

use TransIP\Api\Serializer\DomainsDenormalizer;
use function implode;
use function sprintf;

class Domains extends AbstractApi
{
    /**
     * @return Domain[]
     *
     * @throws HttpClientException
     */
    public function domains(array $tags = [], array $include = []): array
    {
        $optionsResolver = $this->createOptionsResolver();
        $optionsResolver->setDefined('include')
            ->setAllowedTypes('include', 'string');

        $options = [];
        if (! empty($tags)) {
            $options['tags'] = implode(',', $tags);
        }

        if (! empty($include)) {
            $options['include'] = implode(',', $include);
        }

        return $this->serializer->denormalize(
            $this->get('domains', $optionsResolver->resolve($options)),
            DomainsDenormalizer::FORMAT,
            'array'
        );
    }

    /**
     * @throws HttpClientException
     */
    public function domain(string $name, array $include = []): Domain
    {
        $optionsResolver = $this->createOptionsResolver();
        $optionsResolver->setDefined('include')
            ->setAllowedTypes('include', 'string');

        $options = [];
        if (! empty($include)) {
            $options['include'] = implode(',', $include);
        }

        return $this->serializer->denormalize(
            $this->get(sprintf('domains/%s', $name), $optionsResolver->resolve($options)),
            DomainDenormalizer::FORMAT,
            'array'
        );
    }
}
