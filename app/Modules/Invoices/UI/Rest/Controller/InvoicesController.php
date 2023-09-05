<?php

declare(strict_types=1);

namespace App\Modules\Invoices\UI\Rest\Controller;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Application\Command\ApproveInvoice;
use App\Modules\Invoices\Application\Command\RejectInvoice;
use App\Modules\Invoices\Application\Query\InvoiceDetails;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvoicesController extends Controller
{
    public function __construct(
        private readonly InvoiceDetails $invoiceDetails,
        private readonly ApproveInvoice $approveInvoice,
        private readonly RejectInvoice $rejectInvoice,
    ) {
    }

    public function show(string $id): Response
    {
        return new JsonResponse([
            'status' => 'success',
            'data' => [
                'invoices' => ($this->invoiceDetails)($id),
            ],
        ], Response::HTTP_OK);
    }

    public function approve(string $id): Response
    {
        ($this->approveInvoice)(Uuid::fromString($id));
        return new JsonResponse([
            'status' => 'success',
            'data' => null,
        ]);
    }

    public function reject(string $id): Response
    {
        ($this->rejectInvoice)(Uuid::fromString($id));
        return new JsonResponse([
            'status' => 'success',
            'data' => null,
        ]);
    }
}
