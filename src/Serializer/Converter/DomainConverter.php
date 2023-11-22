<?php

declare(strict_types=1);

namespace TransIP\Api\Serializer\Converter;

use DateTime;
use TransIP\Api\Entity\Domain;

final class DomainConverter
{
    public static function forArray(array $domain): Domain
    {
        $nameservers = [];
        foreach ($domain['nameservers'] as $nameserver) {
            $nameservers[] = NameserverConverter::forArray($nameserver);
        }

        $contacts = [];
        foreach ($domain['contacts'] as $contact) {
            $contacts[] = ContactConverter::forArray($contact);
        }

        return new Domain(
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
}
