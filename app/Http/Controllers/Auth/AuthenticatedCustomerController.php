<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginCustomerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

            return to_route('account.show')->with('success', 'You have successfully signed in');
        }

        return to_route('login')->withErrors('Oppes! You have entered invalid credentials');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home')->with('success', 'You have signed out');
    }
}
