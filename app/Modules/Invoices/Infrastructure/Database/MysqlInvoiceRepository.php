<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use App\Modules\Invoices\Domain\Invoices;
use Illuminate\Database\ConnectionInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class MysqlInvoiceRepository implements Invoices
{
    public function __construct(
        private ConnectionInterface $db,
    ) {
    }

    public function find(UuidInterface $id): Invoice
    {
        $invoice =  (array) $this->db->table('invoices')
            ->select([
                'invoices.id',
                'invoices.status',
            ])
            ->where('invoices.id', '=', $id)
            ->first();

        if (null === $invoice || 0 === count($invoice)) {
            throw new InvoiceNotFound($id->toString());
        }

        return new Invoice(
            Uuid::fromString($invoice['id']),
            StatusEnum::from($invoice['status']),
        );
    }

    public function save(Invoice $invoice): void
    {
        $this->db->table('invoices')
            ->updateOrInsert(
                [
                    'id' => $invoice->getId()->toString(),
                ],
                [
                    'status' => $invoice->getStatus()->value,
                ]
            );
    }
}
