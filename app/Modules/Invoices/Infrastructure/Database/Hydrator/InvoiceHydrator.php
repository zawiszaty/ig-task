<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Hydrator;

use App\Modules\Invoices\Application\Query\ReadModel\Model\Invoice;

readonly class InvoiceHydrator
{
    public function hydrate(array $invoice, array $products): Invoice
    {
        $total = 0;

        foreach ($products as $product) {
            $totalProduct = $this->calculateTotalPrice($product);
            $invoice = $this->hydrateProduct($product, $totalProduct, $invoice);
            $total += $totalProduct;
        }
        $invoice['total'] = $total;

        return Invoice::fromArray(
            $invoice
        );
    }

    private function calculateTotalPrice(mixed $product): int
    {
        return $product['price'] * (int)$product['quantity'];
    }

    private function hydrateProduct(array $product, int $totalProduct, array $invoice): array
    {
        $invoice['products'][] = [
            'name' => $product['name'],
            'quantity' => $product['quantity'],
            'unit_price' => $product['price'],
            'total' => $totalProduct,
        ];
        return $invoice;
    }
}
