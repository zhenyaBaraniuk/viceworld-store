<?php

use App\Http\Controllers\Error\NotFoundController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/catalog', fn() => Inertia::render('Catalog/index'));
Route::get('/search', fn() => Inertia::render('Search/index'));
Route::get('/profile', fn() => Inertia::render('Profile/index'));
Route::get('/product', fn() => Inertia::render('Product/index'));
Route::get('/404', NotFoundController::class);
Route::get('/500', fn() => Inertia::render('Error/ServerError'));
Route::get('/', fn() => Inertia::render('Home/index'));
Route::get('/checkout', fn() => Inertia::render('Checkout/index'));
Route::get('/success-order', fn() => Inertia::render('SuccessOrder/index'));
