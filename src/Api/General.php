<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;
use function sprintf;

class General extends AbstractApi
{
    /**
     * @throws HttpClientException
     */
    public function products(): array
    {
        return $this->get('products');
    }

    /**
     * @throws HttpClientException
     */
    public function productElements(string $productName): array
    {
        return $this->get(sprintf('products/%s/elements', $productName));
    }

    /**
     * @throws HttpClientException
     */
    public function availabilityZones(): array
    {
        return $this->get('availability-zones');
    }

    /**
     * @throws HttpClientException
     */
    public function apiTest(): array
    {
        return $this->get('api-test');
    }
}
