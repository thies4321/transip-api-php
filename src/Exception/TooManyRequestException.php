<?php

declare(strict_types=1);

namespace TransIP\Api\Exception;

final class TooManyRequestException extends RuntimeException
{
    public static function forMessage(string $message): self
    {
        return new self($message, 429);
    }
}
