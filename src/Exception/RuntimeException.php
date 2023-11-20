<?php

declare(strict_types=1);

namespace TransIP\Api\Exception;

use RuntimeException as NativeRuntimeException;

class RuntimeException extends NativeRuntimeException implements ExceptionInterface
{
}
