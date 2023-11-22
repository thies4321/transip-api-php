<?php

declare(strict_types=1);

namespace TransIP\Api\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

use function sprintf;

final class Authentication implements Plugin
{
    private array $headers;

    public function __construct(string $token)
    {
        $this->headers = ['Authorization' => sprintf('Bearer %s', $token)];
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        foreach ($this->headers as $header => $value) {
            $request = $request->withHeader($header, $value);
        }

        return $next($request);
    }
}
