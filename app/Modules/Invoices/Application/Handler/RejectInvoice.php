<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Handler;

use App\Modules\Invoices\Api\Events\InvoiceRejected;
use App\Modules\Invoices\Domain\Invoices;

readonly class RejectInvoice
{
    public function __construct(private Invoices $invoices)
    {
    }

    public function handle(InvoiceRejected $event): void
    {
        $invoice = $this->invoices->find($event->id);

        $invoice->reject();

        $this->invoices->save($invoice);
    }
}
