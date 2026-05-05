<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('customers.list');
    }

    public function view(User $user): bool
    {
        return $user->can('customers.view');
    }
}
