<?php
namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->level === 'admin';
    }

    public function create(User $user)
    {
        return $user->level === 'admin';
    }

    // metode lainnya
}
