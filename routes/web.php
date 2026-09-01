<?php

use App\Http\Controllers\Auth\AuthenticatedCustomerController;
use App\Http\Controllers\Auth\RegisteredCustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Error\NotFoundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\OrderController;
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
        Route::get('/', HomeController::class)->name('home');
        Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
        Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/search', SearchController::class)->name('search');
        Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
        Route::get('/success-order', fn () => Inertia::render('SuccessOrder/index'))->name('success-order');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/cart/items', [CartItemController::class, 'store'])->name('cart.items.store');
        Route::patch('/cart/items/{cartItem}', [CartItemController::class, 'update'])->name('cart.items.update');
        Route::delete('/cart/items/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.items.destroy');

        Route::get('/404', NotFoundController::class);
        Route::get('/500', fn () => Inertia::render('Error/ServerError'));

        Route::middleware('guest:customer')->group(function (): void {
            Route::get('/login', [AuthenticatedCustomerController::class, 'login'])->name('login');
            Route::post('/login', [AuthenticatedCustomerController::class, 'checkLogin'])->name('login.check');
            Route::get('/register', [RegisteredCustomerController::class, 'create'])->name('register');
            Route::post('/register', [RegisteredCustomerController::class, 'store'])->name('register.store');
        });

        Route::middleware('auth:customer')->group(function (): void {
            require __DIR__.'/profile.php';
        });
    });

Route::post('/newsletter/subscribe', [NewsletterSubscriberController::class, 'store'])->name('newsletter.subscribe');
