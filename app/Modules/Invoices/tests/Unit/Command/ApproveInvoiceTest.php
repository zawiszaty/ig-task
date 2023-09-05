<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Unit\Command;

use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Application\Command\ApproveInvoice;
use App\Modules\Invoices\Domain\CantChangeInvoiceStatus;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Invoices;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ApproveInvoiceTest extends TestCase
{
    // Mocks for dependencies
    private $invoices;
    private $approvalFacade;

    protected function setUp(): void
    {
        $this->invoices = $this->createMock(Invoices::class);
        $this->approvalFacade = $this->createMock(ApprovalFacadeInterface::class);
    }

    public function testApproveValidInvoice(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = new Invoice($invoiceId, StatusEnum::DRAFT);

        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);
        $this->approvalFacade->expects($this->once())
            ->method('approve')
            ->with($this->isInstanceOf(ApprovalDto::class));

        $approveInvoice = new ApproveInvoice($this->invoices, $this->approvalFacade);
        $approveInvoice($invoiceId);
    }

    public function testApproveNonDraftInvoice(): void
    {
        $invoiceId = Uuid::uuid4();
        $invoice = new Invoice($invoiceId, StatusEnum::APPROVED);
        $this->invoices->expects($this->once())
            ->method('find')
            ->with($invoiceId)
            ->willReturn($invoice);

        $this->expectException(CantChangeInvoiceStatus::class);

        $approveInvoice = new ApproveInvoice($this->invoices, $this->approvalFacade);
        $approveInvoice($invoiceId);
    }
}
