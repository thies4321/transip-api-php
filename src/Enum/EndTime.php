<?php

declare(strict_types=1);

namespace TransIP\Api\Enum;

enum EndTime: string
{
    case End = 'end';
    case Immediately = 'immediately';
}
