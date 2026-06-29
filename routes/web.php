<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Error\NotFoundController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/'.config('app.locale'));

Route::prefix('{locale}')
    ->whereIn('locale', ['en', 'uk'])
    ->group(function () {
        Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
        Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/search', fn () => Inertia::render('Search/index'));
        Route::get('/profile', fn () => Inertia::render('Profile/index'));
        Route::get('/', fn () => Inertia::render('Home/index'))->name('home');
        Route::get('/checkout', fn () => Inertia::render('Checkout/index'));
        Route::get('/success-order', fn () => Inertia::render('SuccessOrder/index'));
        Route::get('/404', NotFoundController::class);
        Route::get('/500', fn () => Inertia::render('Error/ServerError'));
    });
