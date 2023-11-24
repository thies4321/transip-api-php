<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class DnsEntry
{
    public function __construct(
        public string $name,
        public int $expire,
        public string $type,
        public string $content,
    ) {
    }
}
