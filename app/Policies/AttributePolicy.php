<?php

namespace App\Policies;

use App\Models\User;

class AttributePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('attributes.list');
    }

    public function create(User $user): bool
    {
        return $user->can('attributes.create');
    }

    public function update(User $user): bool
    {
        return $user->can('attributes.edit');
    }

    public function delete(User $user): bool
    {
        return $user->can('attributes.delete');
    }
}
