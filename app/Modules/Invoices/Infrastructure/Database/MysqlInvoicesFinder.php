<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database;

use App\Modules\Invoices\Application\Query\ReadModel\InvoicesFinder;
use App\Modules\Invoices\Application\Query\ReadModel\Model\Invoice;
use App\Modules\Invoices\Infrastructure\Database\Hydrator\InvoiceHydrator;
use Illuminate\Database\ConnectionInterface;

readonly class MysqlInvoicesFinder implements InvoicesFinder
{
    public function __construct(
        private ConnectionInterface $db,
        private InvoiceHydrator $hydrator
    ) {
    }

    /**
     * @throws InvoiceNotFound
     */
    public function find(string $id): Invoice
    {
        $products = $this->fetchProducts($id);
        $invoice = $this->fetchInvoice($id);

        return $this->hydrator->hydrate($invoice, $products);
    }

    /**
     * @throws InvoiceNotFound
     */
    private function fetchInvoice(string $id): array
    {
        $invoice =  (array) $this->db->table('invoices')
            ->select([
                'invoices.id',
                'invoices.number',
                'invoices.date',
                'invoices.due_date',
                'invoices.status',
                'companies.id as company_id',
                'companies.name',
                'companies.street',
                'companies.city',
                'companies.zip',
                'companies.phone',
                'companies.email',
            ])
            ->join('companies', 'companies.id', '=', 'invoices.company_id')
            ->where('invoices.id', '=', $id)
            ->first();

        if (null === $invoice || 0 === count($invoice)) {
            throw new InvoiceNotFound($id);
        }

        return $invoice;
    }

    private function fetchProducts(string $id): array
    {
        return $this->db->table('invoice_product_lines')
            ->select([
                'invoice_product_lines.product_id',
                'invoice_product_lines.quantity',
                'products.id',
                'products.name',
                'products.price',
                'products.currency',
            ])
            ->join('products', 'products.id', '=', 'invoice_product_lines.product_id')
            ->where('invoice_product_lines.invoice_id', '=', $id)
            ->get()
            ->map(fn($productLine) => (array) $productLine)
            ->toArray();
    }
}
