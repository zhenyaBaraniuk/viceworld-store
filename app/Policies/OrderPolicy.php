<?php

namespace App\Policies;

use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('orders.list');
    }

    public function view(User $user): bool
    {
        return $user->can('orders.view');
    }

    public function update(User $user): bool
    {
        return $user->can('orders.edit');
    }
}
