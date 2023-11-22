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
}
