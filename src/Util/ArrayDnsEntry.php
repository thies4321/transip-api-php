<?php

declare(strict_types=1);

namespace TransIP\Api\Util;

use TransIP\Api\Entity\DnsEntry;

final class ArrayDnsEntry
{
    public static function denormalize(array $dnsEntry): DnsEntry
    {
        return new DnsEntry(
            $dnsEntry['name'],
            $dnsEntry['expire'],
            $dnsEntry['type'],
            $dnsEntry['content'],
        );
    }

    public static function normalize(DnsEntry $dnsEntry): array
    {
        return [
            'name' => $dnsEntry->name,
            'expire' => $dnsEntry->expire,
            'type' => $dnsEntry->type,
            'content' => $dnsEntry->content,
        ];
    }
}
