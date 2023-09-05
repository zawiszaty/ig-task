<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use RuntimeException;

class CantChangeInvoiceStatus extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Cant change invoice status');
    }
}
