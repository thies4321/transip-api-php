<?php

declare(strict_types=1);

namespace TransIP\Api\Api;

use Http\Client\Exception as HttpClientException;
use TransIP\Api\Entity\Product;
use TransIP\Api\Entity\ProductElement;
use TransIP\Api\Util\ArrayProduct;
use TransIP\Api\Util\ArrayProductElement;
use function array_map;
use function sprintf;

class General extends AbstractApi
{
    /**
     * @throws HttpClientException
     */
    public function products(): array
    {
        $products = [];

        foreach ($this->get('products')['products'] as $category => $productsArray) {
            foreach ($productsArray as $product) {
                $product['category'] = $category;
                $products[] = Product::createFromArray($product);
            }
        }

        return $products;
    }

    /**
     * @throws HttpClientException
     */
    public function productElements(string $productName): array
    {
        return array_map(function (array $productElement) {
            return ProductElement::createFromArray($productElement);
        }, $this->get(sprintf('products/%s/elements', $productName))['productElements']);
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
