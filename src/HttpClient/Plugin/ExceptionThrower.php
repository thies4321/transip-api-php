<?php

declare(strict_types=1);

namespace TransIP\Api\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use TransIP\Api\Exception\BadRequestException;
use TransIP\Api\Exception\ConflictException;
use TransIP\Api\Exception\ExceptionInterface;
use TransIP\Api\Exception\ForbiddenException;
use TransIP\Api\Exception\InternalServerErrorException;
use TransIP\Api\Exception\MethodNotAllowedException;
use TransIP\Api\Exception\NotAcceptableException;
use TransIP\Api\Exception\NotFoundException;
use TransIP\Api\Exception\NotImplementedException;
use TransIP\Api\Exception\RequestTimeoutException;
use TransIP\Api\Exception\RuntimeException;
use TransIP\Api\Exception\TooManyRequestException;
use TransIP\Api\Exception\UnauthorizedException;
use TransIP\Api\Exception\UnprocessableEntityException;
use TransIP\Api\HttpClient\Message\ResponseMediator;

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
        return match ($status) {
            400 => BadRequestException::forMessage($message),
            401 => UnauthorizedException::forMessage($message),
            403 => ForbiddenException::forMessage($message),
            404 => NotFoundException::forMessage($message),
            405 => MethodNotAllowedException::forMessage($message),
            406 => NotAcceptableException::forMessage($message),
            408 => RequestTimeoutException::forMessage($message),
            409 => ConflictException::forMessage($message),
            422 => UnprocessableEntityException::forMessage($message),
            429 => TooManyRequestException::forMessage($message),
            500 => InternalServerErrorException::forMessage($message),
            501 => NotImplementedException::forMessage($message),
            default => new RuntimeException($message, $status),
        };
    }
}
