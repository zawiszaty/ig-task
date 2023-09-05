<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Domain\Enums\StatusEnum;
use Ramsey\Uuid\UuidInterface;

class Invoice
{
    public function __construct(
        readonly private UuidInterface $id,
        private StatusEnum $status,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function approve(): void
    {
        if (StatusEnum::DRAFT !== $this->status) { // in real live I will move it to Policy pattern
            throw new CantChangeInvoiceStatus();
        }
        $this->status = StatusEnum::APPROVED;
    }

    public function reject(): void
    {
        if (StatusEnum::DRAFT !== $this->status) { // in real live I will move it to Policy pattern
            throw new CantChangeInvoiceStatus();
        }
        $this->status = StatusEnum::REJECTED;
    }

    public function canReject(): bool
    {
        return StatusEnum::DRAFT === $this->status;
    }

    public function canApprove(): bool
    {
        return StatusEnum::DRAFT === $this->status;
    }
}
