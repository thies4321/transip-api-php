<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

use DateTime;

final class Domain
{
    public function __construct(
        public string $name,
        public array $nameservers,
        public array $contacts,
        public string $authCode,
        public bool $isTransferLocked,
        public DateTime $registrationDate,
        public DateTime $renewalDate,
        public bool $isWhitelabel,
        public ?DateTime $cancellationDate,
        public ?string $cancellationStatus,
        public bool $isDnsOnly,
        public array $tags,
        public bool $canEditDns,
        public bool $hasAutoDns,
        public bool $hasDnsSec,
        public string $status,
    ) {
    }
}
