<?php

declare(strict_types=1);

use App\Modules\Invoices\UI\Rest\Controller\InvoicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('invoices')->group(function (): void {
    Route::get('/{id}', [InvoicesController::class, 'show']);
    Route::get('/{id}/reject', [InvoicesController::class, 'reject']);
    Route::get('/{id}/approve', [InvoicesController::class, 'approve']);
});
