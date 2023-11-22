<?php

declare(strict_types=1);

namespace TransIP\Api;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use TransIP\Api\Api\Account;
use TransIP\Api\Api\Domains;
use TransIP\Api\Api\General;
use TransIP\Api\HttpClient\Builder;
use TransIP\Api\HttpClient\Plugin\Authentication;
use TransIP\Api\HttpClient\Plugin\ExceptionThrower;
use TransIP\Api\HttpClient\Plugin\History;

class Client
{
    private const BASE_URL = 'https://api.transip.nl';
    private const USER_AGENT = 'transip-api-php/1.0';

    private Builder $httpClientBuilder;
    private History $responseHistory;

    public function __construct(?Builder $httpClientBuilder = null)
    {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();
        $this->responseHistory = new History();

        $builder->addPlugin(new ExceptionThrower());
        $builder->addPlugin(new HistoryPlugin($this->responseHistory));
        $builder->addPlugin(new HeaderDefaultsPlugin(['User-Agent' => self::USER_AGENT]));
        $builder->addPlugin(new RedirectPlugin());

        $this->setUrl(self::BASE_URL);
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    public function authenticate(string $token): void
    {
        $this->httpClientBuilder->removePlugin(Authentication::class);
        $this->httpClientBuilder->addPlugin(new Authentication($token));
    }

    public function setUrl(string $url): void
    {
        $uri = $this->httpClientBuilder->getUriFactory()->createUri($url);

        $this->httpClientBuilder->removePlugin(AddHostPlugin::class);
        $this->httpClientBuilder->addPlugin(new AddHostPlugin($uri));
    }

    public function getLastResponse(): ?ResponseInterface
    {
        return $this->responseHistory->getLastResponse();
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->httpClientBuilder->getHttpClient();
    }

    public function general(): General
    {
        return new General($this);
    }

    public function account(): Account
    {
        return new Account($this);
    }

    public function domains(): Domains
    {
        return new Domains($this);
    }

//    /**
//     * Get the stream factory.
//     *
//     * @return StreamFactoryInterface
//     */
//    public function getStreamFactory(): StreamFactoryInterface
//    {
//        return $this->getHttpClientBuilder()->getStreamFactory();
//    }
}
