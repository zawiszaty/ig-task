<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Unit\Handler;

use App\Modules\Invoices\Api\Events\InvoiceApproved;
use App\Modules\Invoices\Application\Handler\ApproveInvoice;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Invoices;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ApproveInvoiceTest extends TestCase
{
    private $invoices;

    protected function setUp(): void
    {
        $this->invoices = $this->createMock(Invoices::class);
    }

    public function testHandleInvoiceApprovedEvent(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = $this->createMock(Invoice::class);
        $invoiceApprovedEvent = new InvoiceApproved($invoiceId);
        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);
        $invoice->expects($this->once())
            ->method('approve');
        $this->invoices->expects($this->once())
            ->method('save')
            ->with($invoice);

        $approveInvoiceHandler = new ApproveInvoice($this->invoices);
        $approveInvoiceHandler->handle($invoiceApprovedEvent);
    }
}
