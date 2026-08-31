<?php

namespace App\Http\Requests;

use App\Enums\Order\DeliveryMethod;
use App\Enums\Payment\PaymentProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'phone:UA'],
            'delivery_method' => ['required', Rule::enum(DeliveryMethod::class)],
            'payment_method' => ['required', Rule::enum(PaymentProvider::class)],
            'city' => [Rule::requiredIf(fn () => $this->input('delivery_method') === DeliveryMethod::COURIER->value), 'string', 'max:255'],
            'street' => [Rule::requiredIf(fn () => $this->input('delivery_method') === DeliveryMethod::COURIER->value), 'string', 'max:255'],
        ];
    }
}
