<?php

declare(strict_types=1);

namespace App\Infrastructure\Events\Translation;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Invoices\Api\Events\InvoiceRejected;
use Illuminate\Contracts\Events\Dispatcher;

class EntityRejectedHandler
{
    public function __construct(
        private Dispatcher $dispatcher
    ) {
    }

    public function handle(EntityRejected $entityRejected): void
    {
        if ('invoice' === $entityRejected->approvalDto->entity) {
            $this->dispatcher->dispatch(new InvoiceRejected($entityRejected->approvalDto->id));
        }
    }
}
