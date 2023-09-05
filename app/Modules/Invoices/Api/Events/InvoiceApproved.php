<?php

namespace App\Modules\Invoices\Api\Events;

use Ramsey\Uuid\UuidInterface;

readonly class InvoiceApproved
{
    public function __construct(public UuidInterface $id)
    {
    }
}
