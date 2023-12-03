<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Exception;
use Http\Client\Exception as HttpClientException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TransIP\Api\Entity\Contact;
use TransIP\Api\Entity\DnsEntry;
use TransIP\Api\Entity\Domain;
use TransIP\Api\Entity\Nameserver;

use TransIP\Api\Enum\EndTime;
use function array_map;
use function implode;
use function sprintf;

class Domains extends AbstractApi
{
    /**
     * @return Domain[]
     *
     * @throws HttpClientException
     * @throws Exception
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
            return Domain::createFromArray($domain);
        }, $this->get('domains', $optionsResolver->resolve($options))['domains']);
    }

    /**
     * @throws HttpClientException
     * @throws Exception
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

        return Domain::createFromArray(
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
                $params['contacts'][] = $contact->toArray();
            }
        }

        if (! empty($nameservers)) {
            foreach ($nameservers as $nameserver) {
                $params['nameservers'][] = $nameserver->toArray();
            }
        }

        if (! empty($dnsEntries)) {
            foreach ($dnsEntries as $dnsEntry) {
                $params['dnsEntries'][] = $dnsEntry->toArray();
            }
        }

        $this->post('domains', $params);
    }

    /**
     * @throws HttpClientException
     */
    public function transfer(string $name, string $authcode,  array $contacts = [], array $nameservers = [], array $dnsEntries = []): void
    {
        $params = [
            'domainName' => $name,
            'authCode' => $authcode,
        ];

        if (!empty($contacts)) {
            foreach ($contacts as $contact) {
                $params['contacts'][] = $contact->toArray();
            }
        }

        if (! empty($nameservers)) {
            foreach ($nameservers as $nameserver) {
                $params['nameservers'][] = $nameserver->toArray();
            }
        }

        if (! empty($dnsEntries)) {
            foreach ($dnsEntries as $dnsEntry) {
                $params['dnsEntries'][] = $dnsEntry->toArray();
            }
        }

        $this->post('domains', $params);
    }

    public function update(Domain $domain): void
    {
        $this->put(sprintf('domains/%s', $domain->name), ['domain' => $domain->toArray()]);
    }

    public function cancel(string $domainName, EndTime $endTime): void
    {
        $this->delete(sprintf('domains/%s', $domainName), ['endTime' => $endTime->value]);
    }
}
