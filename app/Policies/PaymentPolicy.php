<?php

namespace App\Policies;

use App\Models\User;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('payments.list');
    }

    public function view(User $user): bool
    {
        return $user->can('payments.view');
    }
}
