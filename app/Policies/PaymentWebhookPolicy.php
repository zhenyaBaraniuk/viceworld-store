<?php

namespace App\Policies;

use App\Models\User;

class PaymentWebhookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('payment-webhooks.list');
    }

    public function view(User $user): bool
    {
        return $user->can('payment-webhooks.view');
    }
}
