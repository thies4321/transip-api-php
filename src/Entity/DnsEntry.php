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

    public static function createFromArray(array $dnsEntry): self
    {
        return new self(
            $dnsEntry['name'],
            $dnsEntry['expire'],
            $dnsEntry['type'],
            $dnsEntry['content'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'expire' => $this->expire,
            'type' => $this->type,
            'content' => $this->content,
        ];
    }
}
