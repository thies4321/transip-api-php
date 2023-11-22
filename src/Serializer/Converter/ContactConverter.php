<?php

declare(strict_types=1);

namespace TransIP\Api\Serializer\Converter;

use TransIP\Api\Entity\Contact;

final class ContactConverter
{
    public static function forArray(array $contact): Contact
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
}
