<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class Contact
{
    public function __construct(
        public string $type,
        public string $firstName,
        public string $lastName,
        public string $companyName,
        public string $companyKvk,
        public string $companyType,
        public string $street,
        public string $number,
        public string $postalCode,
        public string $city,
        public string $phoneNumber,
        public string $faxNumber,
        public string $email,
        public string $country,
    ) {
    }

    public static function createFromArray(array $contact): self
    {
        return new self(
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

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'companyName' => $this->companyName,
            'companyKvk' => $this->companyKvk,
            'companyType' => $this->companyType,
            'street' => $this->street,
            'number' => $this->number,
            'postalCode' => $this->postalCode,
            'city' => $this->city,
            'phoneNumber' => $this->phoneNumber,
            'faxNumber' => $this->faxNumber,
            'email' => $this->email,
            'country' => $this->country,
        ];
    }
}
