<?php

declare(strict_types=1);

namespace TransIP\Api\Util;

use TransIP\Api\Entity\Nameserver;

final class ArrayNameserver
{
    public static function denormalize(array $nameserver): Nameserver
    {
        return new Nameserver(
            $nameserver['hostname'],
            $nameserver['ipv4'],
            $nameserver['ipv6']
        );
    }

    public static function normalize(Nameserver $nameserver): array
    {
        return [
            'hostname' => $nameserver->hostname,
            'ipv4' => $nameserver->ipv4,
            'ipv6' => $nameserver->ipv6,
        ];
    }
}
