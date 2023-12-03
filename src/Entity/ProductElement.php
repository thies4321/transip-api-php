<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class ProductElement
{
    public function __construct(
        public string $name,
        public string $description,
        public int $amount,
    ) {
    }

    public static function createFromArray(array $productElement): self
    {
        return new self(
            $productElement['name'],
            $productElement['description'],
            $productElement['amount'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'amount' => $this->amount,
        ];
    }
}
