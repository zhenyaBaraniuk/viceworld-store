<?php

use App\Http\Controllers\Auth\AuthenticatedCustomerController;
use App\Http\Controllers\ProfileController;

Route::post('/logout', [AuthenticatedCustomerController::class, 'logout'])->name('logout');

Route::prefix('account')->name('account.')->group(function (): void {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::post('/', [ProfileController::class, 'update'])->name('update');

    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/address', [ProfileController::class, 'updateAddress'])->name('settings.address');
});
