<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/payment', [PaymentController::class, 'store']);

Route::prefix('webhooks')->group(function () {
    Route::post('/liqpay', [WebhookController::class, 'liqpay']);
});
