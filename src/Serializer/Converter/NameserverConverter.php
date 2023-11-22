<?php

declare(strict_types=1);

namespace TransIP\Api\Serializer\Converter;

use TransIP\Api\Entity\Nameserver;

final class NameserverConverter
{
    public static function forArray(array $nameserver): Nameserver
    {
        return new Nameserver(
            $nameserver['hostname'],
            $nameserver['ipv4'],
            $nameserver['ipv6']
        );
    }
}
