<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Unit\Command;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Application\Command\RejectInvoice;
use App\Modules\Invoices\Domain\CantChangeInvoiceStatus;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Invoices;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class RejectInvoiceTest extends TestCase
{
    // Mocks for dependencies
    private $invoices;
    private $approvalFacade;

    protected function setUp(): void
    {
        $this->invoices = $this->createMock(Invoices::class);
        $this->approvalFacade = $this->createMock(ApprovalFacadeInterface::class);
    }

    public function testRejectValidInvoice(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = new Invoice($invoiceId, StatusEnum::DRAFT);

        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);
        $this->approvalFacade->expects($this->once())
            ->method('reject')
            ->with($this->isInstanceOf(ApprovalDto::class));

        $rejectInvoice = new RejectInvoice($this->invoices, $this->approvalFacade);
        $rejectInvoice($invoiceId);
    }

    public function testRejectNonDraftInvoice(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = new Invoice($invoiceId, StatusEnum::APPROVED);
        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);

        $this->expectException(CantChangeInvoiceStatus::class);

        $rejectInvoice = new RejectInvoice($this->invoices, $this->approvalFacade);
        $rejectInvoice($invoiceId);
    }
}
