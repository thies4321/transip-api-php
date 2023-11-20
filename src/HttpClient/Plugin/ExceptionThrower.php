<?php

declare(strict_types=1);

namespace TransIP\Api\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use TransIP\Api\Exception\ApiLimitExceededException;
use TransIP\Api\Exception\ExceptionInterface;
use TransIP\Api\Exception\RuntimeException;
use TransIP\Api\Exception\ValidationFailedException;

final class ExceptionThrower implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response): ResponseInterface {
            $status = $response->getStatusCode();

            if ($status >= 400 && $status < 600) {
                throw self::createException($status, ResponseMediator::getErrorMessage($response) ?? $response->getReasonPhrase());
            }

            return $response;
        });
    }

    private static function createException(int $status, string $message): ExceptionInterface
    {
        if (400 === $status || 422 === $status) {
            return new ValidationFailedException($message, $status);
        }

        if (429 === $status) {
            return new ApiLimitExceededException($message, $status);
        }

        return new RuntimeException($message, $status);
    }
}
