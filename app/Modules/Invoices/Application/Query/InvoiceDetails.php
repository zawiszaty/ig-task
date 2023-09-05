<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Query;

use App\Modules\Invoices\Application\Query\ReadModel\InvoicesFinder;
use App\Modules\Invoices\Application\Query\ReadModel\Model\Invoice;

readonly class InvoiceDetails
{
    public function __construct(private InvoicesFinder $invoicesFinder)
    {
    }

    public function __invoke(string $id): Invoice
    {
        return $this->invoicesFinder->find($id);
    }
}
