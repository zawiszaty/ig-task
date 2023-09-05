<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Application\Query\ReadModel\InvoicesFinder;
use App\Modules\Invoices\Domain\Invoices;
use App\Modules\Invoices\Infrastructure\Database\MysqlInvoiceRepository;
use App\Modules\Invoices\Infrastructure\Database\MysqlInvoicesFinder;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class InvoicesServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoicesFinder::class, MysqlInvoicesFinder::class);
        $this->app->scoped(Invoices::class, MysqlInvoiceRepository::class);
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            InvoicesFinder::class,
            Invoices::class,
        ];
    }
}
