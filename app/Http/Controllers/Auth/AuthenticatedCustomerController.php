<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCustomerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedCustomerController extends Controller
{
    public function login(): Response
    {
        return Inertia::render('Login/index');
    }

    public function checkLogin(LoginCustomerRequest $request): RedirectResponse
    {
        $customerData = $request->only(['email', 'password']);
        $rememberMe = $request->boolean('remember_me');

        if (Auth::guard('customer')->attempt($customerData, $rememberMe)) {
            $request->session()->regenerate();

            return to_route('home');
        }

        return to_route('login')->withErrors('Oppes! You have entered invalid credentials');
    }
}
