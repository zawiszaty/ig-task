<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Command;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\CantChangeInvoiceStatus;
use App\Modules\Invoices\Domain\Invoices;
use Ramsey\Uuid\UuidInterface;

readonly class RejectInvoice
{
    public function __construct(
        private Invoices $invoices,
        private ApprovalFacadeInterface $approvalFacade,
    ) {
    }

    public function __invoke(UuidInterface $id): void
    {
        $invoice = $this->invoices->find($id);

        if (!$invoice->canReject()) {
            throw new CantChangeInvoiceStatus();
        }
        $this->approvalFacade->reject(
            new ApprovalDto(
                $invoice->getId(),
                $invoice->getStatus(),
                'invoice'
            )
        );
    }
}
