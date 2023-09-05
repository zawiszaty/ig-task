<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvoiceNotFound extends NotFoundHttpException
{
    public function __construct(string $id)
    {
        parent::__construct("Invoice with id {$id} not found.");
    }
}
