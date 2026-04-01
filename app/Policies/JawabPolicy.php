<?php

namespace App\Policies;

use App\Models\Jawab;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JawabPolicy
{
    public function update(User $user, Jawab $jawab): bool
    {
        return $user->id === $jawab->user_id;
    }

    public function delete(User $user, Jawab $jawab): bool
    {
        return $user->id === $jawab->user_id
            || $user->role === 'admin';
    }
}
