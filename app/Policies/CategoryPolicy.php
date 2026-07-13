<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('categories.list');
    }

    public function create(User $user): bool
    {
        return $user->can('categories.create');
    }

    public function update(User $user): bool
    {
        return $user->can('categories.edit');
    }

    public function delete(User $user): bool
    {
        return $user->can('categories.delete');
    }
}
