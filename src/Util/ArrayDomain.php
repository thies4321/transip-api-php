<?php

namespace TransIP\Api\Util;

use DateTime;
use Exception;
use TransIP\Api\Entity\Domain;

use function array_map;

final class ArrayDomain
{
    /**
     * @throws Exception
     */
    public static function denormalize(array $domain): Domain
    {
        $nameservers = array_map(function (array $nameserver) {
            return ArrayNameserver::denormalize($nameserver);
        }, $domain['nameservers'] ?? []);

        $contacts = array_map(function (array $contact) {
            return ArrayContact::denormalize($contact);
        }, $domain['contacts'] ?? []);

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
