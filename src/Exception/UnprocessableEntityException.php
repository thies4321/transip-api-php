<?php

declare(strict_types=1);

namespace TransIP\Api\Exception;

final class UnprocessableEntityException extends ErrorException
{
    public static function forMessage(string $message): self
    {
        return new self($message, 422);
    }
}
