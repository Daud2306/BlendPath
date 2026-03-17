<?php

namespace App\Policies;

use App\Models\Tanya;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TanyaPolicy
{
    public function update(User $user, Tanya $tanya): bool
    {
        return $user->id === $tanya->user_id;
    }

    public function delete(User $user, Tanya $tanya): bool
    {
        return $user->id === $tanya->user_id
            || $user->role === 'admin';
    }
}
