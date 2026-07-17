<?php

namespace App\Data\Customer;

use App\Models\Customer;
use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public ?string $phone,
        public ?CustomerAddressData $address,
    ) {}

    public static function fromModel(Customer $customer): self
    {
        $customerAddress = $customer->addresses()->first();

        return new self(
            $customer->first_name,
            $customer->last_name,
            $customer->email,
            $customer->phone,
            $customerAddress ? CustomerAddressData::fromModel($customerAddress) : null,
        );
    }
}
