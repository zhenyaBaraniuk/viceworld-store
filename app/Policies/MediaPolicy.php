<?php

namespace App\Policies;

use App\Models\User;

class MediaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('media.list');
    }

    public function view(User $user): bool
    {
        return $user->can('media.view');
    }

    public function update(User $user): bool
    {
        return $user->can('media.edit');
    }

    public function delete(User $user): bool
    {
        return $user->can('media.delete');
    }
}
