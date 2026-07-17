<?php

use App\Http\Controllers\Auth\AuthenticatedCustomerController;
use App\Http\Controllers\ProfileController;

\Illuminate\Support\Facades\Route::post('/logout', [AuthenticatedCustomerController::class, 'logout'])->name('logout');

\Illuminate\Support\Facades\Route::prefix('account')->name('account.')->group(function (): void {
    \Illuminate\Support\Facades\Route::get('/', [ProfileController::class, 'show'])->name('show');
    \Illuminate\Support\Facades\Route::post('/', [ProfileController::class, 'update'])->name('update');

    \Illuminate\Support\Facades\Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    \Illuminate\Support\Facades\Route::post('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password');
    \Illuminate\Support\Facades\Route::post('/settings/address', [ProfileController::class, 'updateAddress'])->name('settings.address');
});
