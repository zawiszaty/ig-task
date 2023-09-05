<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Handler;

use App\Modules\Invoices\Api\Events\InvoiceApproved;
use App\Modules\Invoices\Domain\Invoices;

readonly class ApproveInvoice
{
    public function __construct(private Invoices $invoices)
    {
    }

    public function handle(InvoiceApproved $event): void
    {
        $invoice = $this->invoices->find($event->id);

        $invoice->approve();

        $this->invoices->save($invoice);
    }
}
