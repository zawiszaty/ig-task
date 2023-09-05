<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Unit\Domain;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Invoice;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InvoiceTest extends TestCase
{
    public function testInvoiceConstruction(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::DRAFT);

        $this->assertInstanceOf(UuidInterface::class, $invoice->getId());
        $this->assertEquals($uuid, $invoice->getId());
        $this->assertInstanceOf(StatusEnum::class, $invoice->getStatus());
        $this->assertEquals(StatusEnum::DRAFT, $invoice->getStatus());
    }

    public function testApproveInvoice(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::DRAFT);

        $invoice->approve();

        $this->assertEquals(StatusEnum::APPROVED, $invoice->getStatus());
    }

    public function testRejectInvoice(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::DRAFT);

        $invoice->reject();

        $this->assertEquals(StatusEnum::REJECTED, $invoice->getStatus());
    }

    public function testCanRejectInvoiceInDraftStatus(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::DRAFT);

        $canReject = $invoice->canReject();

        $this->assertTrue($canReject);
    }

    public function testCannotRejectInvoiceInApprovedStatus(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::APPROVED);

        $canReject = $invoice->canReject();

        $this->assertFalse($canReject);
    }

    public function testCanApproveInvoiceInDraftStatus(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::DRAFT);

        $canApprove = $invoice->canApprove();

        $this->assertTrue($canApprove);
    }

    public function testCannotApproveInvoiceInApprovedStatus(): void
    {
        $uuid = Uuid::uuid4();
        $invoice = new Invoice($uuid, StatusEnum::APPROVED);

        $canApprove = $invoice->canApprove();

        $this->assertFalse($canApprove);
    }
}
