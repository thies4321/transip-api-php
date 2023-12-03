<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

use DateTime;
use Exception;
use SensitiveParameter;

use function array_map;

final class Domain
{
    public function __construct(
        public string                       $name,
        /** @var Nameserver[] $nameservers */
        public array                        $nameservers,
        /** @var Contact[] $contacts */
        public array                        $contacts,
        #[SensitiveParameter] public string $authCode,
        public bool                         $isTransferLocked,
        public DateTime                     $registrationDate,
        public DateTime                     $renewalDate,
        public bool                         $isWhitelabel,
        public ?DateTime                    $cancellationDate,
        public ?string                      $cancellationStatus,
        public bool                         $isDnsOnly,
        public array                        $tags,
        public bool                         $canEditDns,
        public bool                         $hasAutoDns,
        public bool                         $hasDnsSec,
        public string                       $status,
    ) {
    }

    /**
     * @throws Exception
     */
    public static function createFromArray(array $domain): self
    {
        $nameservers = array_map(function (array $nameserver) {
            return Nameserver::createFromArray($nameserver);
        }, $domain['nameservers'] ?? []);

        $contacts = array_map(function (array $contact) {
            return Contact::createFromArray($contact);
        }, $domain['contacts'] ?? []);

        return new self(
            $domain['name'],
            $nameservers,
            $contacts,
            $domain['authCode'],
            $domain['isTransferLocked'],
            new DateTime($domain['registrationDate']),
            new DateTime($domain['renewalDate']),
            $domain['isWhitelabel'],
            empty($domain['cancellationDate']) ? null : new DateTime($domain['cancellationDate']),
            empty($domain['cancellationStatus']) ? null : $domain['cancellationStatus'],
            $domain['isDnsOnly'],
            $domain['tags'],
            $domain['canEditDns'],
            $domain['hasAutoDns'],
            $domain['hasDnsSec'],
            $domain['status'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'nameservers' => array_map(function (Nameserver $nameserver) {
                return $nameserver->toArray();
            }, $this->nameservers),
            'contacts' => array_map(function (Contact $contact) {
                return $contact->toArray();
            }, $this->contacts),
            'authCode' => $this->authCode,
            'isTransferLocked' => $this->isTransferLocked,
            'registrationDate' => $this->registrationDate->format('Y-m-d'),
            'renewalDate' => $this->renewalDate->format('Y-m-d'),
            'isWhitelabel' => $this->isWhitelabel,
            'cancellationDate' => $this->cancellationDate?->format('Y-m-d H:i:s'),
            'cancellationStatus' => $this->cancellationStatus,
            'isDnsOnly' => $this->isDnsOnly,
            'tags' => $this->tags,
            'canEditDns' => $this->canEditDns,
            'hasAutoDns' => $this->hasAutoDns,
            'hasDnsSec' => $this->hasDnsSec,
            'status' => $this->status,
        ];
    }
}
