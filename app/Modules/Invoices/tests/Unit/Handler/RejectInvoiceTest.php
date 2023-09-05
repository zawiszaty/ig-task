<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Unit\Handler;

use App\Modules\Invoices\Api\Events\InvoiceRejected;
use App\Modules\Invoices\Application\Handler\RejectInvoice;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Invoices;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RejectInvoiceTest extends TestCase
{
    private $invoices;

    protected function setUp(): void
    {
        $this->invoices = $this->createMock(Invoices::class);
    }

    public function testHandleInvoiceRejectedEvent(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = $this->createMock(Invoice::class);
        $invoiceRejectedEvent = new InvoiceRejected($invoiceId);
        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);
        $invoice->expects($this->once())
            ->method('reject');
        $this->invoices->expects($this->once())
            ->method('save')
            ->with($invoice);

        $rejectInvoiceHandler = new RejectInvoice($this->invoices);
        $rejectInvoiceHandler->handle($invoiceRejectedEvent);
    }
}
