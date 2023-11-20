<?php

declare(strict_types=1);

namespace TransIP\Api;

use TransIP\Api\HttpClient\Builder;
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
    }
}
