<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;

class Account extends AbstractApi
{
    /**
     * @throws HttpClientException
     */
    public function invoices(): array
    {
        return $this->get('invoices');
    }
}
