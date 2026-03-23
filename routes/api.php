<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/payments', [PaymentController::class, 'store']);

Route::prefix('webhooks')->group(function () {
    Route::post('/liqpay', [WebhookController::class, 'liqpay']);
    Route::post('/monobank', [WebhookController::class, 'monobank']);
});
