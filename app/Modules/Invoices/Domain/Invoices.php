<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use Ramsey\Uuid\UuidInterface;

interface Invoices
{
    public function find(UuidInterface $id): Invoice;
    public function save(Invoice $invoice): void;
}
