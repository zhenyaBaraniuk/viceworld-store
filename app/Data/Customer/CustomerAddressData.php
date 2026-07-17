<?php

namespace App\Data\Customer;

use App\Models\CustomerAddress;
use Spatie\LaravelData\Data;

class CustomerAddressData extends Data
{
    public function __construct(
        public string $city,
        public string $street,
        public string $building,
        public ?string $apartment,
        public bool $is_default,
    ) {}

    public static function fromModel(CustomerAddress $customerAddress): self
    {
        return new self(
            $customerAddress->city,
            $customerAddress->street,
            $customerAddress->building,
            $customerAddress->apartment,
            $customerAddress->is_default,
        );
    }
}
