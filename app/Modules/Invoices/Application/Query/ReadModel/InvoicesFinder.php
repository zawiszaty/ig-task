<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Query\ReadModel;

use App\Modules\Invoices\Application\Query\ReadModel\Model\Invoice;

interface InvoicesFinder
{
    public function find(string $id): Invoice;
}
