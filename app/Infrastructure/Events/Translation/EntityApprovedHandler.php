<?php

declare(strict_types=1);

namespace App\Infrastructure\Events\Translation;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Invoices\Api\Events\InvoiceApproved;
use Illuminate\Contracts\Events\Dispatcher;

class EntityApprovedHandler
{
    public function __construct(
        private Dispatcher $dispatcher
    )
    {
    }

    public function handle(EntityApproved $entityRejected): void
    {
        if ('invoice' === $entityRejected->approvalDto->entity) {
            $this->dispatcher->dispatch(new InvoiceApproved($entityRejected->approvalDto->id));
        }
    }
}
