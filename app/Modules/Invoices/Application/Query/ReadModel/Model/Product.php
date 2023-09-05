<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Query\ReadModel\Model;

readonly class Product
{
    public function __construct(
        public string $name,
        public int $quantity,
        public float $unitPrice,
        public float $total,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['quantity'],
            $data['unit_price'],
            $data['total'],
        );
    }
}
