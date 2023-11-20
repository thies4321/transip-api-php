<?php

declare(strict_types=1);

namespace TransIP\Api\HttpClient\Util;

use TransIP\Api\Exception\RuntimeException;

use function get_debug_type;
use function is_array;
use function json_decode;
use function json_encode;
use function json_last_error;
use function json_last_error_msg;
use function sprintf;

use const JSON_ERROR_NONE;

final class JsonArray
{
    public static function decode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException(sprintf('json_decode error: %s', json_last_error_msg()));
        }

        if (!is_array($data)) {
            throw new RuntimeException(sprintf('json_decode error: Expected JSON of type array, %s given.', get_debug_type($data)));
        }

        return $data;
    }

    public static function encode(array $value): string
    {
        $json = json_encode($value);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException(sprintf('json_encode error: %s', json_last_error_msg()));
        }

        return $json;
    }
}
