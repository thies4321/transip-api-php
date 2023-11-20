<?php

declare(strict_types=1);

namespace TransIP\Api\Exception;

use ErrorException as NativeErrorException;

class ErrorException extends NativeErrorException implements ExceptionInterface
{
}
