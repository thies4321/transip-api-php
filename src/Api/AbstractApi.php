<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TransIP\Api\Client;
use TransIP\Api\HttpClient\Message\ResponseMediator;
use TransIP\Api\HttpClient\Util\JsonArray;
use TransIP\Api\HttpClient\Util\QueryStringBuilder;

use function array_filter;
use function array_merge;
use function count;
use function rawurlencode;
use function sprintf;

abstract class AbstractApi
{
    private const URI_PREFIX = '/v6/';

    private Client $client;
    private ?int $perPage = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws HttpClientException
     */
    protected function getAsResponse(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        if (null !== $this->perPage && !isset($params['per_page'])) {
            $params['per_page'] = $this->perPage;
        }

        return $this->client->getHttpClient()->get(self::prepareUri($uri, $params), $headers);
    }

    /**
     * @throws HttpClientException
     */
    protected function get(string $uri, array $params = [], array $headers = []): array|string
    {
        $response = $this->getAsResponse($uri, $params, $headers);

        return ResponseMediator::getContent($response);
    }

    /**
     * @throws HttpClientException
     */
    protected function post(string $uri, array $params = [], array $headers = [], array $uriParams = []): array|string
    {
        $body = self::prepareJsonBody($params);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->post(self::prepareUri($uri, $uriParams), $headers, $body);

        return ResponseMediator::getContent($response);
    }

    /**
     * @throws HttpClientException
     */
    protected function put(string $uri, array $params = [], array $headers = []): array|string
    {
        $body = self::prepareJsonBody($params);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->put(self::prepareUri($uri), $headers, $body ?? '');

        return ResponseMediator::getContent($response);
    }

    /**
     * @throws HttpClientException
     */
    protected function patch(string $uri, array $params = [], array $headers = []): array|string
    {
        $body = self::prepareJsonBody($params);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->patch(self::prepareUri($uri), $headers, $body ?? '');

        return ResponseMediator::getContent($response);
    }

    /**
     * @throws HttpClientException
     */
    protected function delete(string $uri, array $params = [], array $headers = []): array|string
    {
        $body = self::prepareJsonBody($params);

        if (null !== $body) {
            $headers = self::addJsonContentType($headers);
        }

        $response = $this->client->getHttpClient()->delete(self::prepareUri($uri), $headers, $body ?? '');

        return ResponseMediator::getContent($response);
    }

    protected static function encodePath(int|string $uri): string
    {
        return rawurlencode((string) $uri);
    }

    protected function createOptionsResolver(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined('page')
            ->setAllowedTypes('page', 'int')
            ->setAllowedValues('page', function ($value): bool {
                return $value > 0;
            })
        ;
        $resolver->setDefined('per_page')
            ->setAllowedTypes('per_page', 'int')
            ->setAllowedValues('per_page', function ($value): bool {
                return $value > 0 && $value <= 100;
            })
        ;

        return $resolver;
    }

    private static function prepareUri(string $uri, array $query = []): string
    {
        $query = array_filter($query, function ($value): bool {
            return null !== $value;
        });

        return sprintf('%s%s%s', self::URI_PREFIX, $uri, QueryStringBuilder::build($query));
    }

    private static function prepareJsonBody(array $params): ?string
    {
        $params = array_filter($params, function ($value): bool {
            return null !== $value;
        });

        if (0 === count($params)) {
            return null;
        }

        return JsonArray::encode($params);
    }

    private static function addJsonContentType(array $headers): array
    {
        return array_merge([ResponseMediator::CONTENT_TYPE_HEADER => ResponseMediator::JSON_CONTENT_TYPE], $headers);
    }
}
