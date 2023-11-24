<?php

declare(strict_types=1);

namespace TransIP\Api\Entity;

final class Invoice
{
    public function __construct(
        public string $invoiceNumber,
        public string $creationDate,
        public string $payDate,
        public string $dueDate,
        public string $invoiceStatus,
        public string $currency,
        public string $totalAmount,
        public string $totalAmountInclVat,
    ) {
    }
}
