<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentWebhook;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $payments = Payment::factory()->count(20)->create();

        Transaction::factory()->count(20)->recycle($payments)->create();
        PaymentWebhook::factory()->count(20)->recycle($payments)->create();
    }
}
