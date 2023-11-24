<?php

declare(strict_types=1);

namespace TransIP\Api\Util;

use TransIP\Api\Entity\Contact;

final class ArrayContact
{
    public static function denormalize(array $contact): Contact
    {
        return new Contact(
            $contact['type'],
            $contact['firstName'],
            $contact['lastName'],
            $contact['companyName'],
            $contact['companyKvk'],
            $contact['companyType'],
            $contact['street'],
            $contact['number'],
            $contact['postalCode'],
            $contact['city'],
            $contact['phoneNumber'],
            $contact['faxNumber'],
            $contact['email'],
            $contact['country'],
        );
    }

    public static function normalize(Contact $contact): array
    {
        return [
            'type' => $contact->type,
            'firstName' => $contact->firstName,
            'lastName' => $contact->lastName,
            'companyName' => $contact->companyName,
            'companyKvk' => $contact->companyKvk,
            'companyType' => $contact->companyType,
            'street' => $contact->street,
            'number' => $contact->number,
            'postalCode' => $contact->postalCode,
            'city' => $contact->city,
            'phoneNumber' => $contact->phoneNumber,
            'faxNumber' => $contact->faxNumber,
            'email' => $contact->email,
            'country' => $contact->country,
        ];
    }
}
