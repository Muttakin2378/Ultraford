<?php

namespace App\Policies;

use App\Models\Alamat;
use App\Models\User;

class AlamatPolicy
{
    /**
     * Determine whether the user can update the alamat.
     */
    public function update(User $user, Alamat $alamat): bool
    {
        return $user->id === $alamat->user_id;
    }

    /**
     * Determine whether the user can delete the alamat.
     */
    public function delete(User $user, Alamat $alamat): bool
    {
        return $user->id === $alamat->user_id;
    }
}
