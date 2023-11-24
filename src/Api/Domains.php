<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;
use TransIP\Api\Entity\Contact;
use TransIP\Api\Entity\DnsEntry;
use TransIP\Api\Entity\Domain;
use TransIP\Api\Entity\Nameserver;
use TransIP\Api\Util\ArrayContact;
use TransIP\Api\Util\ArrayDnsEntry;
use TransIP\Api\Util\ArrayDomain;

use TransIP\Api\Util\ArrayNameserver;
use function array_map;
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
        $optionsResolver->setDefined('tags')
            ->setAllowedTypes('tags', 'string');
        $optionsResolver->setDefined('include')
            ->setAllowedTypes('include', 'string');

        $options = [];
        if (! empty($tags)) {
            $options['tags'] = implode(',', $tags);
        }

        if (! empty($include)) {
            $options['include'] = implode(',', $include);
        }

        return array_map(function (array $domain) {
            return ArrayDomain::denormalize($domain);
        }, $this->get('domains', $optionsResolver->resolve($options))['domains']);
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

        return ArrayDomain::denormalize(
            $this->get(sprintf('domains/%s', $name), $optionsResolver->resolve($options))['domain']
        );
    }

    /**
     * @param Contact[] $contacts
     * @param Nameserver[] $nameservers
     * @param DnsEntry[] $dnsEntries
     *
     * @throws HttpClientException
     */
    public function register(string $name, array $contacts = [], array $nameservers = [], array $dnsEntries = []): void
    {
        $params = ['domainName' => $name];

        if (!empty($contacts)) {
            foreach ($contacts as $contact) {
                $params['contacts'][] = ArrayContact::normalize($contact);
            }
        }

        if (! empty($nameservers)) {
            foreach ($nameservers as $nameserver) {
                $params['nameservers'][] = ArrayNameserver::normalize($nameserver);
            }
        }

        if (! empty($dnsEntries)) {
            foreach ($dnsEntries as $dnsEntry) {
                $params['dnsEntries'][] = ArrayDnsEntry::normalize($dnsEntry);
            }
        }

        $this->post('domains', $params);
    }
}
