<?php

namespace App\Http\Controllers;

use App\Data\Customer\CustomerData;
use App\Http\Requests\UpdateCustomerAddressRequest;
use App\Http\Requests\UpdateCustomerPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Inertia\Response;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Profile/PersonalInformation', [
            'customer' => CustomerData::fromModel($this->customer()),
        ]);
    }

    public function update(UpdateCustomerRequest $request): RedirectResponse
    {
        $customerData = $request->validated();

        $this->customer()->update($customerData);

        return to_route('account.show')->with('success', 'Profile has been updated');
    }

    public function settings(): Response
    {
        return Inertia::render('Profile/Settings', [
            'customer' => CustomerData::fromModel($this->customer()),
        ]);
    }

    public function updatePassword(UpdateCustomerPasswordRequest $request): RedirectResponse
    {
        $this->customer()->update([
            'password' => Hash::make($request->validated('new_password'))
        ]);

        return to_route('account.show')->with('success', 'Password has been updated');
    }

    public function updateAddress(UpdateCustomerAddressRequest $request): RedirectResponse
    {
        $this->customer()->addresses()->updateOrCreate(
            ['is_default' => true],
            $request->validated()
        );

        return to_route('account.show')->with('success', 'Address has been updated');
    }

    private function customer(): Customer
    {
        return Auth::guard('customer')->user();
    }
}
