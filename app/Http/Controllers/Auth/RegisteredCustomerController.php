<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisteredCustomerController extends Controller
{
    public function create()
    {
        return Inertia::render('Register/index');
    }

    public function store(RegisterCustomerRequest $request): RedirectResponse
    {
        $customerData = $request->validated();

        $customer = Customer::query()->create([
            ...$customerData,
            'password' => Hash::make($request->validated('password')),
        ]);

        Auth::guard('customer')->login($customer);

        return to_route('home');
    }
}
