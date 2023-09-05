<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Invoices\Api\Events\InvoiceApproved;
use App\Modules\Invoices\Api\Events\InvoiceRejected;
use App\Modules\Invoices\Application\Handler\ApproveInvoice;
use App\Modules\Invoices\Application\Handler\RejectInvoice;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        InvoiceRejected::class => [
            RejectInvoice::class,
        ],
        InvoiceApproved::class => [
            ApproveInvoice::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
