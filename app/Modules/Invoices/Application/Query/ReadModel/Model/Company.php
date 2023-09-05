<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Query\ReadModel\Model;

readonly class Company
{
    public function __construct(
        public string $id,
        public string $name,
        public string $street,
        public string $city,
        public string $zip,
        public string $phone,
    ) {
    }
}
