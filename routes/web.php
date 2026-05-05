<?php

use App\Http\Controllers\Error\NotFoundController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', fn() => Inertia::render('Home/index'));
Route::get('/404', NotFoundController::class);
Route::get('/500', fn() => Inertia::render('Error/ServerError'));
