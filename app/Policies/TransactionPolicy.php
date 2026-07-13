<?php

namespace App\Policies;

use App\Models\User;

class TransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('transactions.list');
    }

    public function view(User $user): bool
    {
        return $user->can('transactions.view');
    }
}
