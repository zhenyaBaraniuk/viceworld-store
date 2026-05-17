<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class NotFoundController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Error/NotFound');
    }
}
