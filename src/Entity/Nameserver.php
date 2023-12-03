<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class Nameserver
{
    public function __construct(
        public string $hostname,
        public string $ipv4,
        public string $ipv6,
    ) {
    }

    public static function createFromArray(array $nameserver): self
    {
        return new self(
            $nameserver['hostname'],
            $nameserver['ipv4'],
            $nameserver['ipv6']
        );
    }

    public function toArray(): array
    {
        return [
            'hostname' => $this->hostname,
            'ipv4' => $this->ipv4,
            'ipv6' => $this->ipv6,
        ];
    }
}
