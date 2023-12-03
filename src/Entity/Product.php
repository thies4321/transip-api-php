<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class Product
{
    public function __construct(
        public string $category,
        public string $name,
        public string $description,
        public int $price,
        public int $recurringPrice,
    ) {
    }

    public static function createFromArray(array $product): self
    {
        return new self(
            $product['category'],
            $product['name'],
            $product['description'],
            $product['price'],
            $product['recurringPrice'],
        );
    }

    public function toArray(): array
    {
        return [
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'recurringPrice' => $this->recurringPrice,
        ];
    }
}
