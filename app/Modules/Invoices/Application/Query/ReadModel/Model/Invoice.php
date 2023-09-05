<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Query\ReadModel\Model;

readonly class Invoice
{
    public function __construct(
        public string $id,
        public string $number,
        public string $date,
        public string $dueDate,
        public BilledCompany $billedCompany,
        public Company $company,
        public array $products,
        public string $status,
        public float $total,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['number'],
            $data['date'],
            $data['due_date'],
            new BilledCompany(
                $data['company_id'],
                $data['name'],
                $data['street'],
                $data['city'],
                $data['zip'],
                $data['phone'],
                $data['email'],
            ),
            new Company(
                $data['company_id'],
                $data['name'],
                $data['street'],
                $data['city'],
                $data['zip'],
                $data['phone'],
            ),
            array_map(fn($product) => Product::fromArray($product), $data['products']),
            $data['status'],
            $data['total'],
        );
    }
}
