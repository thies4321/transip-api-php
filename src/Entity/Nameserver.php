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
}
