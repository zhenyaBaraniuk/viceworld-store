<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Error\NotFoundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\Front\SetLocale;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/'.config('app.locale'));

Route::prefix('{locale}')
    ->whereIn('locale', ['en', 'uk'])
    ->middleware(SetLocale::class)
    ->group(function (): void {
        Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
        Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/search', SearchController::class)->name('search');
        Route::get('/profile', fn () => Inertia::render('Profile/index'));
        Route::get('/', HomeController::class)->name('home');
        Route::get('/checkout', fn () => Inertia::render('Checkout/index'));
        Route::get('/success-order', fn () => Inertia::render('SuccessOrder/index'));
        Route::get('/404', NotFoundController::class);
        Route::get('/500', fn () => Inertia::render('Error/ServerError'));
    });
