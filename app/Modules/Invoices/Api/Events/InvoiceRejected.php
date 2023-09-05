<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Api\Events;

use Ramsey\Uuid\UuidInterface;

readonly class InvoiceRejected
{
    public function __construct(public UuidInterface $id)
    {
    }
}
