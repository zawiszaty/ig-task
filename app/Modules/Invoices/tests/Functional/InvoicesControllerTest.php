<?php

declare(strict_types=1);

namespace App\Modules\Invoices\tests\Functional;

use Illuminate\Database\Connection;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoicesControllerTest extends TestCase
{
    public function testShowInvoice(): void
    {
        $invoice = $this->app->get(Connection::class)->table('invoices')->get()->random()->id;
        $response = $this->json('GET', '/api/invoices/' . $invoice);

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/json');

        $response->assertJson([
            'status' => 'success',
        ]);
    }

    public function testShowInvoiceWhenMissing(): void
    {
        $response = $this->json('GET', '/api/invoices/' . Uuid::uuid4()->toString());

        $response->assertStatus(404)
            ->assertHeader('Content-Type', 'application/json');

        $response->assertJson([
            'status' => 'fail',
        ]);
    }
}
