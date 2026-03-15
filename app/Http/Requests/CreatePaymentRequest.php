<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\PaymentProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['required', Rule::enum(Currency::class)],
            'provider' => ['required', Rule::enum(PaymentProvider::class)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
